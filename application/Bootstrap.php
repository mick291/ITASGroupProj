<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public $frontController;

    /**
     * generate registry
     * @return Zend_Registry
     */
    protected function _initRegistry() {
        $registry = Zend_Registry::getInstance();
        return $registry;
    }

    protected function _initAppAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => 'Application_',
                    'basePath' => dirname(__FILE__),
                ));
        return $autoloader;
    }

    /**
     * Initialized View settings
     */
    protected function _initViewSettings() {
        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('HTML5');

        // set the content type and language
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'en-US');

        // set css/js links and a special import for the accessibility styles
        $this->_view->headLink()->appendStylesheet('/css/reset.css');
        $this->_view->headLink()->appendStylesheet('/css/style.css');

        /* jQuery AND jQueryUI */
        $this->_view->headScript()->appendFile('/js/');
        ;

        $this->_view->addHelperPath('View/Helper', 'View_Helper');
        // setting the site in the title
        $this->_view->headTitle('Care Center');
    }

    /**
     * Initialize Doctrine
     * @return Doctrine_Manager
     */
    public function _initDoctrine() {
        $doctrineConfig = $this->getOption('doctrine');
        $connection = $doctrineConfig['connection'];
        $settings = $doctrineConfig['settings'];

        // Setup Autoloading
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Symfony', APPLICATION_PATH . '/../library');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Entity', APPLICATION_PATH . '/models');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Repository', APPLICATION_PATH . '/models');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Proxy', APPLICATION_PATH . '/cache');
        $classLoader->register();

        // Get ORM config
        $ormConfig = new \Doctrine\ORM\Configuration();

        // Configure Entity Mapping Driver
        $driverImpl = $ormConfig->newDefaultAnnotationDriver(APPLICATION_PATH . '/models/Entity');
        $ormConfig->setMetadataDriverImpl($driverImpl);

        // Configure Proxies
        $ormConfig->setAutoGenerateProxyClasses($settings['autogenerateProxies']);
        $ormConfig->setProxyDir(APPLICATION_PATH . '/cache/Proxy');
        $ormConfig->setProxyNamespace('Proxy');

        // Configure Logging
        //$ormConfig->setSQLLogger(new \Doctrine\DBAL\Logging\FileSQLLogger(APPLICATION_PATH . '/logs');
        $ormConfig->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());

        // Configure Caching
        if (php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
            $settings['cacheType'] = '\Doctrine\Common\Cache\ArrayCache';
        }
        if (is_array($settings['cacheType'])) {
            $ormConfig->setQueryCacheImpl(new $settings['cacheType']['query']);
            $ormConfig->setMetadataCacheImpl(new $settings['cacheType']['metadata']);
        } else {
            $ormConfig->setQueryCacheImpl(new $settings['cacheType']);
            $ormConfig->setMetadataCacheImpl(new $settings['cacheType']);
        }

        // Register Entity Manager
        $entityManager = \Doctrine\ORM\EntityManager::create($connection, $ormConfig);
        \Zend_Registry::set('DoctrineEntityManager', $entityManager);

        return $entityManager;
    }

    protected function _initNavigation() {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');

        $navigation = new Zend_Navigation($config);
        $view->navigation($navigation);
    }

//     protected function _initAcl()
//    {
//        // Create a zend acl
//        $acl = new Zend_Acl();
//
//        // Load acl roles from config
//        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/acl.ini');
//        $roles = $config->acl->roles;
//
//        // Loop through config and establish acl roles
//        foreach ($roles as $child => $parents){
//            if (!$acl->hasRole($child)){
//                if (empty($parents)){
//                    $parents=null;
//                }
//                else {
//                    $parents = explode(',',$parents);
//                }
//                $acl->addRole(new Zend_Acl_Role($child),$parents);
//            }
//        }
//
//        // Set null resource to be allowed
//        $acl->allow(null, null, null);
//
//        $resourcesAllow = $config->acl->resources->allow;
//        $resourcesDeny = $config->acl->resources->deny;
//
//        // Resources denied
//        if ($resourcesDeny != null){
//            foreach ($resourcesDeny as $controller => $parents){
//                if (!$acl->has($controller)){
//                    $acl->addResource($controller);
//                }
//                foreach ($parents as $action => $role){
//                    if ($action == 'all'){
//                        $action = null;
//                    }
//                    $acl->deny(
//                        $role,
//                        $controller,
//                        $action
//                    );
//                }
//            }
//        }
//
//        // Resources allowed
//        if ($resourcesAllow != null){
//            foreach ($resourcesAllow as $controller => $parents){
//                if (!$acl->has($controller)){
//                    $acl->addResource($controller);
//                }
//                foreach ($parents as $action => $role){
//                    if ($action == 'all'){
//                        $action = null;
//                    }
//                    $acl->allow(
//                        $role,
//                        $controller,
//                        $action
//                    );
//                }
//            }
//        }
//
//        Zend_Registry::set('acl',$acl);
//    }

}
