<?
function findUserByPhone($phone)
{
    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['PERSONAL_PHONE' => $phone]);
    if ($buyer = $user -> Fetch())
        return $buyer['ID'];
    else return false;
}

function findUserByEmail($email)
{
    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['EMAIL' => $email]);
    if ($buyer = $user -> Fetch())
        return $buyer['ID'];
    else return false;
}

function getUserByID($id)
{
    global $USER;
    return $USER-> GetByID($id)-> Fetch();
}

function createUser($name = false, $second_name = false, $last_name = false, $email = false, $phone = false, $pass = '', $confirmPass = '', $groupOpt = true)
{
    if(!$email) $email = 'user_'.uniqid().'@hlorka.ua';
    if(!$phone) $phone = '';
    if(!$name) $name = '';
    if(!$second_name) $second_name = '';
    if(!$last_name) $last_name = '';
    $uadd = new CUser;
    //$pass = uniqid();
    $uid = $uadd->Add(['NAME' => $name, 'LAST_NAME' => $last_name, 'SECOND_NAME' => $second_name, 'LOGIN' => $email, 'EMAIL' => $email, 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $confirmPass, 'PERSONAL_PHONE' => $phone]);

    if($groupOpt)
        $uadd->Update($uid, ['UF_UGROUP' => 26]);

    return $uid;
}
