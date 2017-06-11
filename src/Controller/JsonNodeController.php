<?php

namespace Drupal\site_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class JsonNodeController.
 *
 * @package Drupal\site_api\Controller
 */
class JsonNodeController extends ControllerBase {

  /**
   * The serializer service.
   *
   * @var \Symfony\Component\Serializer\Serializer
   */
  private $serializer;

  /**
   * JsonNodeController constructor.
   *
   * @param \Symfony\Component\Serializer\Serializer $serializer
   *   The serializer service.
   */
  public function __construct($serializer)
  {
      $this->serializer = $serializer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $serializer= $container->get('serializer');
    return new static($serializer);
  }

  /**
   * Returns the json representation of a node.
   *
   * @param  string $siteapikey
   *   The site api key
   * @param  [type] $node
   *   The node id.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function jsonNode($siteapikey, $node) {
    // Deny access if first parameter is not the value of siteapikey.
    if ($siteapikey != \Drupal::config('site_api.config')->get('siteapikey')) {
      throw new AccessDeniedHttpException();
    }
    else {
      // Get node object.
      $node_content = Node::load($node);
      // Deny access if this is not a valid node.
      if (!($node_content instanceof Node)) {
        throw new AccessDeniedHttpException();
      }
      else {
        // Get json representation of the node.
        $json_node = $this->serializer->serialize($node_content, 'json');

        // Return json reponse.
        $response = new Response($json_node);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
      }
    }
  }
}
