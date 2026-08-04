<?
class notify
{
    private $testMode = 1, $api_key;
    private $url = 'https://dev.notify.shop/api/v1/tg/';
    private $method='', $post = 1, $params = [];

    public function __construct($api_key)
    {
        $this->api_key=$api_key;
    }

    # general functions
    public function sendNotifyMessage($message_link, $params = [])
    {
        $this->method=$message_link;
        $this->params=$params;

        return $this->_send();
    }

    public function getInviteKey()
    {
        $this->method=$this->api_key.'/getInviteKey';
        $this->post=0;
        return $this->_send();
    }

    # GROUPS
    public function getUserGroup()
    {
        $this->method=$this->api_key.'/userGroups';
        $this->post=0;
        return $this->_send();
    }

    public function updateUserGroup($name, $active, $id=false)
    {
        $this->method=$this->api_key.'/userGroup';
        $this->params['name'] = trim($name);
        $this->params['active'] = trim($active);
        if($id)
            $this->params['id'] = trim($id);
        return $this->_send();
    }

    public function addUserToGroup($tg_user_id, $group_id)
    {
        $this->method=$this->api_key.'/userGroup/'.$group_id.'/linkuser/'.$tg_user_id;
        return $this->_send();
    }

    public function removeUserFromGroup($tg_user_id, $group_id)
    {
        $this->method=$this->api_key.'/userGroup/'.$group_id.'/remove/'.$tg_user_id;
        return $this->_send();
    }

    public function removeGroup($group_id)
    {
        $this->method=$this->api_key.'/userGroup/'.$group_id.'/remove';
        return $this->_send();
    }

    public function getUserListFromGroup($group_id)
    {
        $this->method=$this->api_key.'/userGroup/'.$group_id.'/users';
        $this->post=0;
        return $this->_send();
    }

   /* public function setUserGroups()
    {
        $this->method=$this->api_key.'/setUserGroups';
        return $this->_send();
    }

    public function removeUserGroups()
    {
        $this->method=$this->api_key.'/removeUserGroups';
        return $this->_send();
    }*/
    #/ GROUPS
    
    #public functions


    #private functions
    private function getCurlHeader()
    {
        $header = [
            'Content-Type: application/json',
            //'Content-Length: 0'
        ];

        return $header;
    }


    private function _send()
    {
        $header = $this->getCurlHeader();
        if ($this->post) echo 'POST<br>'; else echo 'GET<br>';
?><pre>URL <?=print_r($this->url.$this->method, 1)?></pre><?
?><pre>$this->params <?=print_r($this->params, 1)?></pre><?
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->url.$this->method );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        if($this->post)
        {
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($this->params) );
        }
        $response = curl_exec( $ch );
        ?><pre>response without json<?=print_r($response, 1)?></pre><?
        $response = json_decode( $response );
        ?><pre>Json response <?=print_r($response, 1)?></pre><?

        return $response;
    }
}
