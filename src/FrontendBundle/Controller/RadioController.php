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
 *     host="{subdomain}.com.ar",
 *     defaults={"subdomain"="radioprovinciadelchaco"},
 *     requirements={"subdomain"="radioprovinciadelchaco|www.radioprovinciadelchaco"}
 * )
 */
class RadioController extends Controller
{
    /**
     * @Route("/", name="radio")
     */
    public function indexAction(Request $request) {
        $diaString=$this->obtener_diaString();
        $diaString=$this->obtener_diaString();
        $em = $this->getDoctrine()->getManager();
        //programas
        $query = $em->createQuery('
            SELECT p FROM BackendBundle:Programa_radio p
            WHERE p.activo = 1
            ORDER BY p.orden ASC
        ');
        $programas = $query->getResult();

        return $this->render('FrontendBundle:Radio:radio.html.twig', array(
            'programas' => $programas,
            'diaString' => $diaString
        ));
    }

    //para obtener la fecha
    private function obtener_diaString() {
        $diasSemana=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
        $meses=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $fecha=$diasSemana[date('w')]. " ". date('j'). "  de ". $meses[date('n')-1].' del '. date('Y');
        return($fecha);
    }

    /**
     * @Route("/horarios_radio", name="horarios_radio")
     */
    public function horariosAction()
    {
        $diaString=$this->obtener_diaString();

        $em = $this->getDoctrine()->getManager();
        //programas destacados
        $query = $em->createQuery('SELECT h FROM BackendBundle:Horario_radio h WHERE h.publicado=1 order by h.id DESC' );
        $horario =  $query->getResult();
        return $this->render('FrontendBundle:Radio:horarios.html.twig',array(
            'horario'=>$horario,
            'diaString'=>$diaString
        ));
    }
}
