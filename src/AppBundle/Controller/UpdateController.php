<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 29/12/2016
 * Time: 22:06
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ApiKey;
use AppBundle\Entity\Category;
use AppBundle\Entity\CJItem;
use AppBundle\Entity\CJSetting;
use AppBundle\Entity\LicenseKey;
use AppBundle\Entity\Media;
use AppBundle\Entity\Page;
use AppBundle\Entity\PasswordHash;
use AppBundle\Entity\Post;
use AppBundle\Entity\Setting;
use AppBundle\Entity\SiteMapEntity;
use AppBundle\Entity\UploadImage;
use AppBundle\Entity\User;
use AppBundle\Entity\Widget;
use Doctrine\ORM\Tools\SchemaTool;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends Controller
{
    /**
     * @Route("/update", name="update")
     */
    public function installAction(Request $request)
    {

        try{

            $form = $this->createForm('AppBundle\Form\Install\UpdateType');
            $form->handleRequest($request);

            $remove_form = $this->createForm('AppBundle\Form\Install\RemoveFileType');
            $remove_form->handleRequest($request);

            //update db
            if ($form->isSubmitted() && $form->isValid()) {

                if($request->request->get('update')){
                    $em = $this->getDoctrine()->getManager();
                    $tool = new SchemaTool($em);
                    $classes = array(

                        $em->getClassMetadata(User::class),
                        $em->getClassMetadata(Page::class),
                        $em->getClassMetadata(Post::class),

                    );
                    $tool->updateSchema($classes);

                    $request->getSession()
                        ->getFlashBag()
                        ->add('db_success', 'Updated database successfully');

                    return $this->redirectToRoute('update');
                }
            }


            //remove file
            if ($remove_form->isSubmitted() && $remove_form->isValid()) {

                if ($request->request->get('remove')) {
                    try {

                      //  unlink('src/AppBundle/Controller/InstallController.php');
                        unlink('src/AppBundle/Controller/UpdateController.php');


                        $request->getSession()
                            ->getFlashBag()
                            ->add('remove_success', 'Update file has been deleted.');

                        return $this->redirectToRoute('homepage');


                    } catch (\Exception $e) {
                        return $this->redirectToRoute('homepage');
                    }
                }

            }


        }catch (Exception $e){
            echo 'There was a problem with the installation: Error - '. $e->getMessage();
        }

        return $this->render($this->getParameter('theme_name').'/update.html.twig',[
            'db_form' => $form->createView(),
            'remove_form' => $remove_form->createView(),
        ]);
    }

}