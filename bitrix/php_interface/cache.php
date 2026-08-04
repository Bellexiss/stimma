<?
/*todo bs_m_2 {created and added this file}*/

CModule::IncludeModule('highloadblock');
CModule::IncludeModule('iblock');

class cache
{
    private static $_instance = null;

    private $cacheTime = 8640000;
    private $obCache;
    private $cache = true;

    private function __construct()
    {
        // приватный конструктор ограничивает реализацию getInstance ()
    }

    protected function __clone()
    {
        // ограничивает клонирование объекта
    }

    static public function getInstance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function isStartCache($cacheKey, $cacheTime = false)
    {
        if ($cacheTime)
            $this -> cacheTime = $cacheTime;

        $site_id = SITE_ID;
        $this -> obCache = new CPHPCache();

        $obCache = $this -> obCache;
        $strCacheID = "BS_SM_CACHE_ID";
        $sCustomCachePath = "/".$site_id."/".$cacheKey;
        //$sCustomCachePath = str_replace('//', '/',$sCustomCachePath);
        //$sCustomCachePath = preg_replace('/\/$/', '',$sCustomCachePath);

        if ($obCache -> StartDataCache($this -> cacheTime, $strCacheID, $sCustomCachePath))
        {
            if ($this -> cacheTime && defined('BX_COMP_MANAGED_CACHE'))
                $GLOBALS['CACHE_MANAGER'] -> StartTagCache($sCustomCachePath);

            return true;
        }
        return false;
    }

    public function endCache($value)
    {
        $obCache = $this -> obCache;

        if ($this -> cacheTime && defined('BX_COMP_MANAGED_CACHE'))
            $GLOBALS['CACHE_MANAGER'] -> EndTagCache();

        $obCache -> EndDataCache($value);
    }

    public function getCacheVars()
    {
        $obCache = $this -> obCache;

        return $obCache -> GetVars();
    }
}
?>