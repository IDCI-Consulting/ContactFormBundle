<?php

namespace IDCI\Bundle\ContactFormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IDCI\Bundle\ContactFormBundle\Entity\Source;
use IDCI\Bundle\ContactFormBundle\Form\SourceType;
use IDCI\Bundle\ContactFormBundle\Entity\SourceProvider;
use IDCI\Bundle\ContactFormBundle\Form\SourceProviderType;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Source controller.
 *
 * @Route("/contact/source")
 */
class AdminSourceController extends Controller
{
    /**
     * Lists all Source entities.
     *
     * @Route("/", name="admin_contact_source")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('IDCIContactFormBundle:Source')->findAll();

        $adapter = new ArrayAdapter($entities);
        $pager = new PagerFanta($adapter);
        $pager->setMaxPerPage($this->container->getParameter('max_per_page'));

        try {
            $pager->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return array(
            'pager' => $pager,
        );
    }

    /**
     * Finds and displays a Source entity.
     *
     * @Route("/{id}/show", name="admin_contact_source_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IDCIContactFormBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Source entity.
     *
     * @Route("/new", name="admin_contact_source_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Source();
        $form   = $this->createForm(new SourceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Source entity.
     *
     * @Route("/create", name="admin_contact_source_create")
     * @Method("POST")
     * @Template("IDCIContactFormBundle:Source:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Source();
        $form = $this->createForm(new SourceType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been created', array(
                    '%entity%' => 'Source',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_contact_source_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Source entity.
     *
     * @Route("/{id}/edit", name="admin_contact_source_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IDCIContactFormBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $editForm = $this->createForm(new SourceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Source entity.
     *
     * @Route("/{id}/update", name="admin_contact_source_update")
     * @Method("POST")
     * @Template("IDCIContactFormBundle:Source:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IDCIContactFormBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SourceType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been updated', array(
                    '%entity%' => 'Source',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_contact_source_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Source entity.
     *
     * @Route("/{id}/delete", name="admin_contact_source_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IDCIContactFormBundle:Source')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Source entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been deleted', array(
                    '%entity%' => 'Source',
                    '%id%'     => $id
                ))
            );
        }

        return $this->redirect($this->generateUrl('admin_contact_source'));
    }

    /**
     * Display Source deleteForm.
     *
     * @Template()
     */
    public function deleteFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IDCIContactFormBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Displays a form to create a new SourceProvider entity.
     *
     * @Route("/provider/{source_id}/new", name="admin_contact_source_provider_new")
     * @Template()
     */
    public function newProviderAction($source_id)
    {
        $em = $this->getDoctrine()->getManager();
        $source = $em->getRepository('IDCIContactFormBundle:Source')->find($source_id);

        if (!$source) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $entity = new SourceProvider();
        $entity->setSource($source);
        $form = $this->createForm(new SourceProviderType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SourceProvider entity.
     *
     * @Route("/provider/{source_id}/create", name="admin_contact_source_provider_create")
     * @Method("POST")
     * @Template("IDCIContactFormBundle:Source:newProvider.html.twig")
     */
    public function createProviderAction(Request $request, $source_id)
    {
        $em = $this->getDoctrine()->getManager();
        $source = $em->getRepository('IDCIContactFormBundle:Source')->find($source_id);

        if (!$source) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $entity = new SourceProvider();
        $entity->setSource($source);
        $form = $this->createForm(new SourceProviderType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been created', array(
                    '%entity%' => 'SourceProvider',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_contact_source_show', array('id' => $source_id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Deletes a SourceProvider entity.
     *
     * @Route("/provider/{id}/delete", name="admin_contact_source_provider_delete")
     * @Method("POST")
     */
    public function deleteProviderAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IDCIContactFormBundle:SourceProvider')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SourceProvider entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been deleted', array(
                    '%entity%' => 'SourceProvider',
                    '%id%'     => $id
                ))
            );
        }

        return $this->redirect($this->generateUrl('admin_contact_source'));
    }

    /**
     * Display SourceProvider deleteForm.
     *
     * @Template()
     */
    public function deleteProviderFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IDCIContactFormBundle:SourceProvider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SourceProvider entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
}
