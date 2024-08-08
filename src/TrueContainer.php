<?php
// in src/TrueContainer.php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TrueContainer extends ContainerBuilder {

    public static function buildContainer()
    {
        $container = new self();
        $container->setParameter('app_root', $rootPath);
        $loader = new YamlFileLoader(
            $container,
            new FileLocator($rootPath . '/config')
        );
        $loader->load('services.yml');
        $container->compile();

        return $container;
    }

    public function get(
        $id,
        $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE
    ) {
        if (strtolower($id) == 'service_container') {
            if (ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE
                !==
                $invalidBehavior
            ) {
                return;
            }
            throw new InvalidArgumentException(
                'The service definition "service_container" does not exist.'
            );
        }

        return parent::get($id, $invalidBehavior);
    }
}