<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/mymedia/{id}", name="_my_media")
     * @Template()
     */
    public function myMediaAction($id)
    {
        $mm = $this->container->get('sonata.media.manager.media');
        $media = $mm->findOneBy(array('id' => $id));
        return array(
            'id' => $id,
            'media' => $media,
        );
    }
    
    /**
     * @Route("/mygallery/{id}", name="_my_gallery")
     * @Template()
     */
    public function myGalleryAction($id)
    {
        $mm = $this->container->get('sonata.media.manager.gallery');
        $gallery = $mm->findOneBy(array('id' => $id));
        return array(
            'id' => $id,
            'gallery' => $gallery,
        );
    }
}
