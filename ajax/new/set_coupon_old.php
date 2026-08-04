<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;

if(isset($_POST['action']) && $_POST['action'] == 'set_coupon')
{
    global $DB;

    $siteId = strpos($_POST['url'],'/ru/') !== false ? 's1' : 's2';
    $isUa = strpos($_POST['url'],'/ru/') === false;

    $coupon = $_POST['coupon'];
    $coupon = trim($coupon);
    $coupon = htmlspecialchars($coupon);
    $coupon = strip_tags($coupon);
    $coupon = str_replace(['\'','"'],'',$coupon);
    $coupon = addslashes($coupon);
    $coupon = mb_strtolower($coupon);

    if(!$_POST['is_order'])
    {
        $text = $isUa ? 'Промокод не діє на акційний товар' : 'Промокод не действует на акционный товар';
        echo json_encode(['status' => 0, 'msg' => $text]);
        die();
    }
    if($_POST['isAction08'] && $coupon != 'Look25')
    {
        $text = $isUa ? 'Промокод не може бути застосований' : 'Промокод не может быть применен';
        echo json_encode(['status' => 0, 'msg' => $text]);
        die();
    }

    $DB -> Query('update b_sale_discount set LID = \''.$siteId.'\'');

    $basket = getBasket();
    $prices = [];
    foreach($basket['ITEMS'] as $index => $item)
    {
        $res = $DB-> Query('select * from b_catalog_price where PRODUCT_ID = '.$item['PRODUCT_ID'].' and (CATALOG_GROUP_ID = 1 || CATALOG_GROUP_ID = 2)');
        while ($record = $res->Fetch())
        {
            $prices[$item['PRODUCT_ID']][$record['CATALOG_GROUP_ID']] = $record['PRICE'];
        }
    }

    $bCoupon = true;
    foreach($prices as $pId => $price)
    {
        if(isset($price[1]) && isset($price[2]) && $price[1] > 0 && $price[2] > 0 && $price[1] > $price[2])
        {
            $bCoupon = false;
            break;
        }
    }

    if(!$bCoupon)
    {
        $text = $isUa ? 'Промокод не може бути застосований' : 'Промокод не может быть применен';
        $text = $isUa ? 'Промокод не діє на акційний товар' : 'Промокод не действует на акционный товар';
        echo json_encode(['status' => 0, 'msg' => $text]);
        die();
    }

    global $USER;

    if(!$USER->IsAuthorized() && $coupon != 'yana10' && $coupon != 'Look25')
    {
        $text = $isUa ? 'Для активації промокоду авторизуйтесь' : 'Для активации промокода авторизуйтесь';
        echo json_encode(['status' => 0, 'msg' => $text]);
        die();
    }
    if($coupon != 'Look25'&&!$USER->IsAuthorized())
    {
        $res = $DB -> Query('select * from raz_zam where UF_COUPON = \''.$coupon.'\' and UF_USER_ID = '.$USER->GetID());
        if($res = $res->Fetch())
        {
            $text = $isUa ? 'Промокод використано раніше' : 'Промокод использован ранее';
            echo json_encode(['status' => 0, 'msg' => $text]);
            die();
        }
    }


    // todo ІІ - наступні 2 строчки були наоборот
    DiscountCouponsManager::init(DiscountCouponsManager::MODE_CLIENT, ['userId' => $USER->GetID()]);
    DiscountCouponsManager::add($coupon);

    // Получаем текущего пользователя
    if($USER->IsAuthorized())
        $userId = $USER->GetID();
    else
        $userId = $userId = CSaleUser::GetAnonymousUserID();

    //DiscountCouponsManager::add($coupon);

    $arCoupons = DiscountCouponsManager::get(true, ['COUPON' => $coupon], true, true);
    $activeCoupon = 0;
    if (!empty($arCoupons))
    {
        $arCoupon = array_shift($arCoupons);
        if ($arCoupon['STATUS'] == DiscountCouponsManager::STATUS_NOT_APPLYED)
            $activeCoupon = 1;
        else $activeCoupon = 0;
    }



    $basket = Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), $siteId);

    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();

    $basket->save();

    if($activeCoupon)
    {
        $_SESSION['COUPON'] = $coupon;
        $text = $isUa ? 'Промокод успішно застосований' : 'Промокод успешно применен';
        //echo json_encode(['status' => 1, 'msg' => $text]);
        //die();
    }
    else
    {
        $text = $isUa ? 'Промокод не знайдений' : 'Промокод не найден';
        echo json_encode(['status' => 0, 'msg' => $text]);
        die();
    }

    $result = DiscountCouponsManager::add($coupon);

    $res = $DB -> Query('select * from b_sale_discount_coupon where COUPON = \''.$coupon.'\'');
    if($coupon = $res -> Fetch())
    {
        $res = $DB -> Query('select * from b_sale_basket where ORDER_ID is null and FUSER_ID = '.CSaleBasket::GetBasketUserID());
        $ids = [];
        while ($record = $res -> Fetch())
            $ids[] = $record['ID'];

        $ids = implode(',',$ids);
        $DB -> Query('update b_sale_basket set DISCOUNT_COUPON = \''.$coupon['ID'].'\' where ID in ('.$ids.')');
        echo json_encode(['status' => 1, 'msg' => 'Промокод успешно применен']);
        die();
    }
    else
    {
        echo json_encode(['status' => 0, 'msg' => 'Промокод не найден']);
        die();
    }

}
