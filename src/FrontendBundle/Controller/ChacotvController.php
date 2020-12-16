<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FrontendBundle\Entity\FormularioContacto;
use FrontendBundle\Form\FormularioContactoType;
use FrontendBundle\Entity\FormularioBusqueda;
use FrontendBundle\Form\FormularioBusquedaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route(
 *     "/",
 *     host="{subdomain}.tv",
 *     defaults={"subdomain"="chaco"},
 *     requirements={"subdomain"="chaco|www.chaco"}
 * )
 */
class ChacotvController extends Controller
{
	/**
	 * @Route("/", name="inicio")
	 */
	public function indexAction(Request $request)
	{
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		//obtengo las noticias destacas del banner inicial
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n WHERE n.destacada=:Destacada AND n.publicado = 1 ORDER BY n.fechaCreacion DESC, n.id DESC');
		$query->setParameter('Destacada','Destacada');
		$destacadas = $query->getResult();
		//obtengo las 40 primeras noticias
		$query = $em->createQuery('
			SELECT n FROM BackendBundle:Noticia n
			WHERE ((n.destacada <> :Destacada AND n.destacada <> :Ahora) OR n.destacada is NULL)
			AND n.publicado = 1
			ORDER BY n.fechaCreacion DESC, n.id DESC
		')->setMaxResults(40);
		$query->setParameter('Destacada','Destacada');
		$query->setParameter('Ahora','Ahora');
		$noticias = $query->getResult();
		//obtengo los videos
		$query = $em->createQuery('SELECT v FROM BackendBundle:Video v WHERE v.publicado = 1 and v.destacada=1 ORDER BY v.fechaCreacion DESC')->setMaxResults(40);
		$videos = $query->getResult();
		//obtengo los sliders
		// $query = $em->createQuery('SELECT s FROM BackendBundle:SlideTexto s  ORDER BY s.orden ASC');
		// $slides = $query->getResult();
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n WHERE n.destacada=:Ahora AND n.publicado = 1 ORDER BY n.fechaCreacion DESC');
		$query->setParameter('Ahora','Ahora');
		$slides = $query->getResult();

		return $this->render('FrontendBundle:Chacotv:index.html.twig',array(
			'destacadas' => $destacadas,
			'noticias' => $noticias,
			'videos' => $videos,
			'slides' => $slides,
			'diaString' => $diaString,
		));
	}

	/**
	 * @Route("/detalleNoticia/{id}", name="detalleNoticia")
	 */
	public function detalleNoticiaAction($id){
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n WHERE n.id= :idNoticia');
		$query->setParameter('idNoticia',$id);
		$noticia = $query->getSingleResult();

		return $this->render('FrontendBundle:Chacotv:detalleNoticia.html.twig', array(
			'noticia' => $noticia,
			'diaString' => $diaString
		));
	}

	/**
	 * @Route("/programas", name="programas")
	 */
	public function programasAction()
	{
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		//programas
		$query = $em->createQuery('SELECT p FROM BackendBundle:Programa p WHERE p.activo=1 ORDER BY p.orden ASC');
		$programas = $query->getResult();
		return $this->render('FrontendBundle:Chacotv:programas.html.twig',array(
			'programas' => $programas,
			'diaString' => $diaString
		));
	}

	/**
	 * @Route("/descripcionPrograma{id}", name="descripcionPrograma")
	 */
	public function descripcionProgramaAction($id)
	{
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();

		//programas destacados
		$query = $em->createQuery('SELECT p FROM BackendBundle:Programa p WHERE p.activo=1 and p.destacado=1 ORDER BY p.orden ASC ' );
		$destacados = $query->getResult();

		//programas
		$query = $em->createQuery('SELECT p FROM BackendBundle:Programa p WHERE p.activo=1 ORDER BY p.orden ASC ' );
		$programas = $query->getResult();

		return $this->render('FrontendBundle:Chacotv:programas.html.twig',array(
			'programas' => $programas,
			'destacados' => $destacados,
			'diaString' => $diaString
		));	
	}

	/**
	 * @Route("/horarios", name="horarios")
	 */
	public function horariosAction()
	{
		$diaString = $this->obtener_diaString();

		$em = $this->getDoctrine()->getManager();
/* 
		//programas destacados
		$query = $em->createQuery('SELECT h FROM BackendBundle:Horario h LIMIT 1 WHERE h.publicado=1 order by h.id DESC ' );
		$horario = $query->getSingleResult(); */

		$qb = $em->createQueryBuilder();
		$qb->select('u')
			->from('BackendBundle:Horario', 'u')
			->where('u.publicado = 1')
			->orderBy('u.id', 'DESC')
			->setMaxResults( 1 );
		$query = $qb->getQuery();
		$horario = $query->getSingleResult();

		return $this->render('FrontendBundle:Chacotv:horarios.html.twig',array(
			'horario' => $horario,
			'diaString' => $diaString
		));
	}

	/**
	 * @Route("/vivo", name="vivo")
	 */
	public function vivoAction()
	{  
		$diaString = $this->obtener_diaString();

		// obtengo un video si existe

		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
		$qb->select('v')
			->from('BackendBundle:VideoEnVivo', 'v')
			->where('v.habilitado = 1')
			->orderBy('v.id', 'DESC')
			->setMaxResults( 1 );
		$query = $qb->getQuery();
		$videoEnVivo = $query->getOneOrNullResult();

		return $this->render('FrontendBundle:Chacotv:vivo.html.twig',array(
			'diaString' => $diaString,
			'videoEnVivo'=>$videoEnVivo
		));
	}

	/**
	 * @Route("/capitulos" , name="capitulos")
	 */
	public function capitulosAction()
	{
		$diaString = $this->obtener_diaString();

		$em = $this->getDoctrine()->getManager();

		//obtengo todos los programas
		$query = $em->createQuery('SELECT p FROM BackendBundle:Programa p WHERE p.activo=1 ' );
		$programas = $query->getResult();

		//obtengo todos los capitulos
		$query = $em->createQuery('SELECT c FROM BackendBundle:Capitulo c WHERE c.publicado=1 ORDER BY c.nroCapitulo ASC ' );
		$capitulos = $query->getResult();

		return $this->render('FrontendBundle:Chacotv:capitulos.html.twig', array(
			'programas' => $programas,
			'capitulos' => $capitulos,
			'diaString' => $diaString
		));
	}

		/**
	 * @Route("/mostrarCapitulos{id}" , name="mostrarCapitulos")
	 */
	public function mostrarCapitulosAction($id)
	{
		$diaString = $this->obtener_diaString();

		$em = $this->getDoctrine()->getManager();

		//obtengo el programa
		$query = $em->createQuery('SELECT p FROM BackendBundle:Programa p WHERE p.id= :idPrograma ' );
		$query->setParameter('idPrograma', $id);
		$programa = $query->getOneOrNullResult();


		//obtengo todos los capitulos
		$query = $em->createQuery('SELECT c FROM BackendBundle:Capitulo c WHERE c.publicado=1 AND c.programa= :idPrograma ORDER BY c.nroCapitulo ASC ' );
		$query->setParameter('idPrograma', $id);
		$capitulos = $query->getResult();

		return $this->render('FrontendBundle:Chacotv:mostrarCapitulos.html.twig', array(
			'capitulos' => $capitulos,
			'diaString' => $diaString,
			'programa' => $programa
		));
	}

	/**
	 * @Route("/contacto", name="contacto")
	 */
	public function contactoAction(Request $request)

	{
		$diaString=$this->obtener_diaString();

		$formularioContacto = new FormularioContacto();
		$form = $this->createForm(FormularioContactoType::class, $formularioContacto);

		$form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid()) {

			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$formularioContacto = $form->getData();

			$message = (new \Swift_Message('Contacto'))
			->setSubject('Contacto Chaco TV')
			->setFrom(array($formularioContacto->email=>$formularioContacto->email))
			->setTo('chacotvlista@ecom.com.ar')
			->setBody("Nombre y Apellido: ".$formularioContacto->nomyap. "\n\nTeléfono: ".$formularioContacto->telefono."\n\n Mensaje: \n\t\t   ".$formularioContacto->mensaje );
			$this->get('mailer')->send($message);

			return $this->render('FrontendBundle:Chacotv:envioContacto.html.twig', array(
							'diaString'=>$diaString
			));
		}

		return $this->render('FrontendBundle:Chacotv:contacto.html.twig',array(
			'form' => $form->createView(),
			'diaString'=>$diaString
		));
	}

	/**
	 * @Route("/noticias", name="noticias")
	 */
	public function noticiasAction()
	{
		$diaString=$this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		//obtengo las noticias destacas del banner inicial
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n WHERE n.destacada=1 AND n.publicado = 1  ORDER BY n.fechaCreacion DESC');
		$destacadas = $query->getResult();
		//obtengo las 40 primeras noticias
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n WHERE n.destacada!=1 AND n.publicado = 1  ORDER BY n.fechaCreacion DESC')->setMaxResults(40);
		$noticias = $query->getResult();
		//obtengo los videos
		$query = $em->createQuery('SELECT v FROM BackendBundle:Video v WHERE v.publicado = 1  ORDER BY v.fechaCreacion DESC');
		$videos = $query->getResult();
		//obtengo los sliders
		$query = $em->createQuery('SELECT s FROM BackendBundle:SlideTexto s  ORDER BY s.orden ASC');
		$slides = $query->getResult();

		return $this->render('FrontendBundle:Chacotv:index.html.twig',array(
			'destacadas'=>$destacadas,
			'noticias'=> $noticias,
			'videos'=>$videos,
			'slides'=>$slides,
			'diaString'=>$diaString
		));
	}

	/**
	 * @Route("/busqueda" , name="busqueda")
	 */
	public function busquedaAction(Request $request)
	{
		$search_query = $request->request->get('search_query');
		$em = $this->getDoctrine()->getManager();
		//busca las noticias
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n  WHERE n.titulo like :search_query  OR n.bajada like :search_query OR n.desarrollo like :search_query  ORDER BY n.fechaCreacion DESC');
		$query->setParameter('search_query', "% ".$search_query." %");
		//dump($query->getResult());
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->query->get('page', 1),
			10
		);

		return $this->render('FrontendBundle:Chacotv:busqueda.html.twig', array(
			'pagination' => $pagination,
			'search_query' => $search_query,
			'diaString' => $this->obtener_diaString()
		));
	}

	/**
	 * @Route("/listaNoticias" , name="listaNoticias")
	 */
	public function listaNoticiasAction(Request $request)
	{
		$formularioBusqueda = new FormularioBusqueda();
		$form = $this->createForm(FormularioBusquedaType::class, $formularioBusqueda);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			// $em = $this->getDoctrine()->getManager();
			// $em->persist($task);
			// $em->flush();
			$search_query = $data->titulo;
			$fechaDesde = $data->fechaDesde;
			$fechaHasta = $data->fechaHasta;
			$diaString = $this->obtener_diaString();
			$em = $this->getDoctrine()->getManager();
			
			//busca las noticias
			$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n  WHERE n.titulo like :search_query  OR n.bajada like :search_query OR n.desarrollo like :search_query  and n.fechaCreacion <= :fechaHasta and n.fechaCreacion >=:fechaDesde ORDER BY n.fechaCreacion DESC');
			$query->setParameter('search_query', "%".$search_query."%");
			$query->setParameter('fechaDesde', $fechaDesde);
			$query->setParameter('fechaHasta', $fechaHasta);

			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
				$query,
				$request->query->get('page', 1),
				10
			);

			return $this->render('FrontendBundle:Chacotv:listaNoticias.html.twig', array('pagination' => $pagination, 'diaString'=>$diaString,
				'search_query' => $search_query,
				'fechaDesde' => $fechaDesde,
				'fechaHasta' => $fechaHasta,
				'form' => $form->createView()
			));
		} else {
			$diaString = $this->obtener_diaString();
			$em = $this->getDoctrine()->getManager();
			$dql = "SELECT n FROM BackendBundle:Noticia n WHERE n.publicado = 1  ORDER BY n.fechaCreacion DESC";
			$query = $em->createQuery($dql);

			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
				$query, /* query NOT result */
				$request->query->getInt('page', 1)/*page number*/,
				10/*limit per page*/
			);

			// parameters to template
			return $this->render('FrontendBundle:Chacotv:listaNoticias.html.twig', array(
				'pagination' => $pagination,
				'diaString' => $diaString,
				'form' => $form->createView()
			));
		}
	}

	/**
	 * @Route("/listaVideos" , name="listaVideos")
	 */
	public function listaVideosAction(Request $request)
	{
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		$dql = "SELECT v FROM BackendBundle:Video v WHERE v.publicado = 1  ORDER BY v.fechaCreacion DESC";
		$query = $em->createQuery($dql);

		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query, /* query NOT result */
			$request->query->getInt('page', 1)/*page number*/,
			10/*limit per page*/
		);

		// parameters to template
		return $this->render('FrontendBundle:Chacotv:listaVideos.html.twig', array(
			'pagination' => $pagination, 'diaString' => $diaString
		));
	}

	/**
	 * @Route("/detalleVideo{id}", name="detalleVideo")
	 */
	public function detalleVideoAction($id){
		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT v FROM BackendBundle:Video v WHERE v.id= :idVideo');
		$query->setParameter('idVideo',$id);
		$video = $query->getSingleResult();

		return $this->render('FrontendBundle:Chacotv:detalleVideo.html.twig', array(
			'video' => $video,
			'diaString' => $diaString
		));
	}

	private function obtener_diaString(){
		$diasSemana=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$meses=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$fecha=$diasSemana[date('w')]. " ". date('j'). "  de ". $meses[date('n')-1].' del '. date('Y');
		return($fecha);
	}

	public function buscarNoticiasAction(Request $request,$search_query,$fechaDesde,$fechaHasta)
	{

		$diaString = $this->obtener_diaString();
		$em = $this->getDoctrine()->getManager();

		//busca las noticias
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n  WHERE n.titulo like :search_query  OR n.bajada like :search_query OR n.desarrollo like :search_query  and n.fechaCreacion <= :fechaHasta and n.fechaCreacion >=:fechaDesde ORDER BY n.fechaCreacion DESC');
		$query->setParameter('search_query', "%".$search_query."%");
		$query->setParameter('fechaDesde', $fechaDesde);
		$query->setParameter('fechaHasta', $fechaHasta);

		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->query->get('page', 1),
			10
		);

		return $this->render('FrontendBundle:Chacotv:listaNoticias.html.twig', array(
			'pagination' => $pagination,
			'diaString' => $diaString,
			'search_query' => $search_query,
			'fechaDesde' => $fechaDesde,
			'fechaHasta' => $fechaHasta
		));
	}

	/**
	 * @Route("/rss_noticias", name="rss_noticias")
	 */
	public function rssNoticias()
	{
		//obtengo las 10 primeras noticias
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT n FROM BackendBundle:Noticia n  WHERE n.publicado = 1  ORDER BY n.fechaCreacion DESC')
			->setMaxResults(10);
		$noticias = $query->getResult();

		$templatePath = 'FrontendBundle:Chacotv:rssNoticias.html.twig';
		$parameters = ['noticias' => $noticias];
		$view = $this->renderView($templatePath, $parameters);

		$response = new Response(
			$view,
			Response::HTTP_OK,
			array('content-type' => 'xml')
		);

		return $response;
	}
}
