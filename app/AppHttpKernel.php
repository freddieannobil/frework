<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class AppHttpKernel extends Kernel
{


    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \AppBundle\AppBundle()
        ];

        if($this->getEnvironment() == 'dev'){

            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new \Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new \Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }


    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');

        $isDevEnv =  $this->getEnvironment() == 'dev';
        $loader->load(function (ContainerBuilder $container) use($isDevEnv){
            if($isDevEnv){
                $container->loadFromExtension('web_profiler', [
                    'toolbar' => true
                ]);
            }

            if($isDevEnv){
                $container->loadFromExtension('framework', [
                    'router' => [
                        'resource' => '%kernel.root_dir%/config/routing_dev.yml'
                    ]

                ]);
            }
        });
    }
}