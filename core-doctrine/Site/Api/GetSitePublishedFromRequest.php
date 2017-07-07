<?php

namespace Zrcms\CoreDoctrine\Site\Api;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Site\Model\SitePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSitePublishedFromRequest implements \Zrcms\Core\Site\Api\GetSitePublishedFromRequest
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return SitePublished|null
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            \Zrcms\CoreDoctrine\Site\Entity\SitePublished::class
        );

        $host = $request->getUri()->getHost();

        return $repository->find(
            $host
        );
    }
}
