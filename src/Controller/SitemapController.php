<?php
 
namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Answer;
use App\Entity\Session;

 
class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $urls = [];
        $hostname = $request->getSchemeAndHttpHost();
 
        // add static urls
        $urls[] = array('loc' => $this->generateUrl('index'));
        $urls[] = array('loc' => $this->generateUrl('about'));
        $urls[] = array('loc' => $this->generateUrl('contact'));
        $urls[] = array('loc' => $this->generateUrl('legal-mentions'));
        $urls[] = array('loc' => $this->generateUrl('patchnotes'));
        $urls[] = array('loc' => $this->generateUrl('rules'));

        $urls[] = array('loc' => $this->generateUrl('app_forgot_password_request'));
        $urls[] = array('loc' => $this->generateUrl('app_check_email'));
        
        $urls[] = array('loc' => $this->generateUrl('login'));
        $urls[] = array('loc' => $this->generateUrl('logout'));

        $urls[] = array('loc' => $this->generateUrl('user_register'));
        $urls[] = array('loc' => $this->generateUrl('user_profile'));
        $urls[] = array('loc' => $this->generateUrl('admin_user'));

        // TODO : adresses dynamiques avec paramètres à gérer en sitemap
        // Then, we will find all our answers stored in the database
        $sessionsRepository = $this->getDoctrine()->getRepository(Session::class);
        $sessions = $sessionsRepository->findAll();

        // We loop on them
        foreach ($sessions as $session) {
            $urls[] = ['loc' => $this->generateUrl('session_show', [
                'id' => $session->getId(),
            ])];
            $urls[] = ['loc' => $this->generateUrl('session_overview', [
                'id' => $session->getId(),
            ])];
            $urls[] = ['loc' => $this->generateUrl('session_cards', [
                'id' => $session->getId(),
            ])];
            for ($orderInNuggets=1; $orderInNuggets < 7; $orderInNuggets++) { 
                $urls[] = ['loc' => $this->generateUrl('nuggets', [
                    'id' => $session->getId(),
                    'orderInNuggets' => $orderInNuggets,
                ])];
            }
            $urls[] = ['loc' => $this->generateUrl('sorp', [
                'id' => $session->getId(),
            ])];
            $urls[] = ['loc' => $this->generateUrl('menus', [
                'id' => $session->getId(),
            ])];
            $urls[] = ['loc' => $this->generateUrl('sum', [
                'id' => $session->getId(),
            ])];
            $urls[] = ['loc' => $this->generateUrl('death_morbol', [
                'id' => $session->getId(),
            ])];
        }
              
        // add static urls with optional tags
        //$urls[] = array('loc' => $this->generateUrl('fos_user_security_login'), 'changefreq' => 'monthly', 'priority' => '1.0');
        //$urls[] = array('loc' => $this->generateUrl('cookie_policy'), 'lastmod' => '2018-01-01');
         
        // add dynamic urls, like blog posts from your DB
        /*foreach ($em->getRepository('BlogBundle:post')->findAll() as $post) {
            $urls[] = array(
                'loc' => $this->generateUrl('blog_single_post', array('post_slug' => $post->getPostSlug()))
            );
        }*/
 
        // add image urls
        /*$products = $em->getRepository('AppBundle:products')->findAll();
        foreach ($products as $item) {
            $images = array(
                'loc' => $item->getImagePath(), // URL to image
                'title' => $item->getTitle()    // Optional, text describing the image
            );
 
            $urls[] = array(
                'loc' => $this->generateUrl('single_product', array('slug' => $item->getProductSlug())),
                'image' => $images              // set the images for this product url
            );
        }*/
       
 
        // return response in XML format
        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', array( 'urls' => $urls,
                'hostname' => $hostname)),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');
 
        return $response;
 
    }
 
}