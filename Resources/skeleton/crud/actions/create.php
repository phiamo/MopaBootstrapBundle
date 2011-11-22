
    /**
     * Creates a new {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/create", name="{{ route_name_prefix }}_create")
     * @Method("post")
     * @Template("{{ bundle }}:{{ entity }}:new.html.twig")
{% endif %}
     */
    public function createAction()
    {
        $entity  = new {{ entity_class }}();
        $request = $this->getRequest();
        $form    = $this->createForm(new {{ entity_class }}Type(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            {% if 'show' in actions -%}
                return $this->redirect($this->generateUrl('{{ route_name_prefix }}_show', array('id' => $entity->getId())));
            {% else -%}
                return $this->redirect($this->generateUrl('{{ route_name_prefix }}'));
            {%- endif %}

        }

{% if 'annotation' == format %}
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
{% endif %}
    }
