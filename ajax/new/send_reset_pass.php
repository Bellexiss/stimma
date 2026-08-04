<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;

$mode = !empty($_POST['code']) ? 'reset' : 'code';

$email = $_POST['email'];

$json = ['status'=>0, 'msg'=>'Невідома помилка'];
$find = CUser::GetList($by = "ID", $order = "ASC", array("EMAIL" => $email), array("SELECT" => ['UF_*']));

if($mode == 'code')
{
    $json['action'] = 'send';
    if($find = $find->Fetch())
    {
        $json = ['status'=>1];

        $checkWord = uniqid();

        $fields = [
            'SITE_NAME' => 'Stimma',
            'EMAIL' => $email,
            'MESSAGE' => 'Ви зробили запит на відновлення паролю. Якщо це були не ви, проігноруйте це повідомлення.',
            'NAME' => $find['NAME'],
            'LAST_NAME' => $find['LAST_NAME'],
            'CHECKWORD' => $checkWord,
            'USER_EMAIL' => $email,
        ];

        $user = new CUser;
        $user->Update($find['ID'], ['UF_CHECKWORD' => $checkWord]);

        if(CEvent::SendImmediate('USER_PASS_REQUEST', 's1', $fields, "Y",3))
            $json['send'] = 1;
        else
            $json['send'] = 0;
    }
    else
    {
        $json['msg'] = 'Користувач з таким email не знайдений';
    }
}
elseif ($mode == 'reset')
{
    $json['action'] = 'reset';
    if($find = $find->Fetch())
    {
        if(empty($_POST['pass']) || empty($_POST['repeat_pass']))
        {
            $json = ['status' => 0];
            $json['msg'] = 'Введіть будь ласка пароль';
        }
        elseif($_POST['pass'] != $_POST['repeat_pass'])
        {
            $json = ['status' => 0];
            $json['msg'] = 'Паролі не співпадають';
        }
        elseif(strlen($_POST['pass']) < 6)
        {
            $json = ['status' => 0];
            $json['msg'] = 'Пароль повинен бути не менше 6 символів';
        }
        elseif($_POST['code'] != $find['UF_CHECKWORD'] || $find['EMAIL'] != $email)
        {
            $json = ['status' => 0];
            $json['msg'] = 'Невірний код';
        }
        else
        {
            $user = new CUser;
            $user->Update($find['ID'], ['PASSWORD' => $_POST['pass'],'CONFIRM_PASSWORD' => $_POST['pass'],'UF_CHECKWORD' => '']);
            $json['msg'] = 'Пароль змінено';
            $json['status'] = 1;
        }
    }
}

$json['mode'] = $mode;

echo json_encode($json);