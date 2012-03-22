<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public $frontController;

    /**
     * generate registry
     * @return Zend_Registry
     */
    
     protected function _initSession()
    {
            Zend_Session::start();
            $sessionRole = new Zend_Session_Namespace('sessionRole');
    }
 
    protected function _initAutoLoad() {

        $modelLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH));
        
        $acl = new Model_Acl();
        $auth = Zend_Auth::getInstance();
        
        $fc = Zend_Controller_Front::getInstance();       
        $fc->registerPlugin(new Plugin_AccessCheck($acl, $auth));
        
        return $modelLoader;
        
    }

    protected function _initRegistry() {
        $registry = Zend_Registry::getInstance();
        return $registry;
    }

    /**
     * Initialized View settings
     */
    protected function _initView() {
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
        $view->headTitle('Care Center')->setSeparator(' - ');
        $view->env = APPLICATION_ENV;

//* setup nav from nav xml file for use in view 
        $navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $navContainer = new Zend_Navigation($navContainerConfig);

        $view->navigation($navContainer);

//* Add view to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer'
        );
        $viewRenderer->setView($view);

//* Return view, so that it can be stored by the bootstrap
        return $view;
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

//protected function _initAcl()
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
