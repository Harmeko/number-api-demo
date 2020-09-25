<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Numbers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api")
 */
class DefaultController extends AbstractController
{
    private $serializer;

    public function __construct() {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $numbers = $this->getDoctrine()
        ->getRepository(Numbers::class)
        ->findAll();

        return $this->render("index.html.twig", ["numbers" => $numbers]);
    }
    
    /**
     * @Route("/numbers", name="numbers", methods={"GET"})
     */
    public function numbers()
    {
        $numbers = $this->getDoctrine()
        ->getRepository(Numbers::class)
        ->findAll();

        $json = $this->serializer->serialize($numbers, 'json');

        return $this->json([
            'message' => 'list of all numbers, yay',
            'data' => $json
        ]);
    }
    
    /**
     * @Route("/numbers", name="addnumbers", methods={"POST"})
     */
    public function addNumbers(Request $request)
    {
        // $arr = json_decode($request->getContent(), true);

        $arr = $request->request->all();
        $list = array_map('intval', explode(',', $arr["array"]));
        
        $numbers = new Numbers();
        $numbers->setList($list);

        $em = $this->getDoctrine()->getManager();

        $em->persist($numbers);
        $em->flush();

        $json = $this->serializer->serialize($numbers, 'json');

        return $this->json([
            'message' => 'list of numbers created, yay',
            'path' => 'src/Controller/DefaultController.php',
            'data' => $numbers
        ]);
    }
    
    /**
     * @Route("/numbers/{id}", name="getnumbers", methods={"GET"})
     */
    public function getNumber($id)
    {
        $numbers = $this->getDoctrine()
            ->getRepository(Numbers::class)
            ->find($id);

        return $this->json([
            'message' => 'this number in particular, yay',
            'path' => 'src/Controller/DefaultController.php',
            // 'data' => $json
            'data' => $numbers
        ]);
    }

    /**
     * v should be PATCH for rest
     * @Route("/numbers/{id}", name="updatenumber", methods={"POST"})
     */
    public function updateNumber(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $arr = json_decode($request->getContent(), true);
        $arr = $request->request->all();
        // $number = array_map('intval', explode(',', $arr["number"]));
        
        $numbers = $em
        ->getRepository(Numbers::class)
        ->find($id);

        if(isset($arr["addNumber"]) && intval($arr["addNumber"]) > 0 ) {
            $numbers->addToList(intval($arr["addNumber"]));
        }
            
        if(isset($arr["removeNumber"])) {
            $numbers->removeFromList(intval($arr["removeNumber"]));
        }
        

        $em->flush();

        $json = $this->serializer->serialize($numbers, 'json');

        return $this->json([
            'message' => 'list updated, yay',
            'path' => 'src/Controller/DefaultController.php',
            'data' => $numbers
        ]);
    }
    
    /**
     * @Route("/numbers/{id}/{operation}", name="manipulatenumber", methods={"POST"})
     */
    public function manipulateNumber(Request $request, $id, $operation)
    {
        $operations = ["add" => true, "substract" => true, "multiply" => true, "divide" => true];
        // $arr = json_decode($request->getContent(), true);
        $arr = $request->request->all();
        $amount = $arr["amount"];
        var_dump($amount);
        
        $numbers = $this->getDoctrine()
        ->getRepository(Numbers::class)
        ->find($id);

        if(isset($amount) && isset($operations[$operation]))
            $numbers->$operation($amount);
        
        $em = $this->getDoctrine()->getManager();

        $em->flush();

        $json = $this->serializer->serialize($numbers, 'json');

        return $this->json([
            'message' => 'list manipulated, yay',
            'path' => 'src/Controller/DefaultController.php',
            'data' => $numbers
        ]);
    }
    
}
