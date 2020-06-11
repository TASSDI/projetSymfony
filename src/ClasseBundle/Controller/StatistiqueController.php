<?php

namespace ClasseBundle\Controller;

use ClasseBundle\ClasseBundle;
use ClasseBundle\Entity\Affecter;
use ClasseBundle\Entity\Note;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MatierBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatistiqueController extends Controller
{
    public function indexAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $classes = $em->getRepository(Note::class)->findAll();
        $totalMoyenne=0;
        $em = $this->getDoctrine()->getManager();
        foreach ($classes as $e){
            $totalMoyenne = $totalMoyenne + 1;
        }

        $data= array();
        $stat=['Note', 'moyenne'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $classe) {
            $stat=array();
            array_push($stat,$classe->getMatiere()->getNomMatiere(),(($classe->getMoyenne()) *100)/$totalMoyenne);
            $nb=($classe->getMoyenne() *100)/$totalMoyenne;
            $stat=[$classe->getMatiere()->getNomMatiere(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des étudiants par niveau');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('ClasseBundle:Stat:Statistique.html.twig', array('piechart' =>
            $pieChart));
    }

}
