<?php


namespace AppBundle\Security;


use AppBundle\Entity\LicenseKey;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Annotation
 */
class SiteAuthentication
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function parse()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $license = $em->getRepository(LicenseKey::class)->getFirstSetting();

        $licensekey = '';
        $localkey ='';
        if(count($license)){
            if(!is_null($license->getLocalKey())){
                $localkey = $license->getLocalKey();
            }

            if(!is_null($license->getLicenseKey()) ){
                $licensekey  = $license->getLicenseKey();
            }
        }

       return $this->init($licensekey, $localkey);
    }

    public function init($licensekey, $localkey='') {
        $results = $this->container->get('app.auth')->license($licensekey, $localkey);
        return $this->result($results);
    }


    private function result($results)
    {
        switch ($results['status']) {
            case "Active":

                if(isset($results['localkey'])){
                   // $localkeydata = str_replace(' ', '',preg_replace('/\s+/', ' ',$results['localkey']));
                    $localkeydata = $results['localkey'];

                    $em = $this->container->get('doctrine.orm.default_entity_manager');
                    $apiKey = $em->getRepository(LicenseKey::class)->getFirstSetting();
                    $apiKey->setLocalKey($localkeydata);
                    $apiKey->setLicenseKey($apiKey->getLicenseKey());

                    $em->flush();

                }
                break;
            case "Invalid":
                die("<h1>License key is Invalid</h1>");
                break;
            case "Expired":
                die("<h1>License key is Expired</h1>");
                break;
            case "Suspended":
                die("<h1>License key is Suspended</h1>");
                break;
            default:
                die("<h1>Invalid Response</h1>");
                break;
        }
    }

}