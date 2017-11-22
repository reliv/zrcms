<?php

namespace Zrcms\HttpTest\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CmsResource\UpsertCmsResource;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Api\CmsResource\FindCmsResource;
use Zrcms\Content\Api\Content\FindContentVersion;
use Zrcms\Content\Api\Content\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Content\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Content\InsertSiteVersion;
use Zrcms\ContentCore\Site\Fields\FieldsSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImplementationTest
{
    const NAME = 'implementation';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var GetUserIdByRequest
     */
    protected $getUserIdByRequest;

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $tests
     */
    public function __construct(
        $serviceContainer,
        array $tests = []
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getUserIdByRequest = $this->serviceContainer->get(GetUserIdByRequest::class);
        $this->contentVersionToArray = $this->serviceContainer->get(ContentVersionToArray::class);

        $this->tests = [
            'site' => [
                'api' => [
                    UpsertCmsResource::class => UpsertSiteCmsResource::class,
                    FindCmsResource::class => FindSiteCmsResource::class,
                    FindContentVersion::class => FindSiteVersion::class,
                    InsertContentVersion::class => InsertSiteVersion::class,
                ],
                'class' => [
                    ContentVersion::class => SiteVersionBasic::class,
                ],
                'cmsResource' => [

                ],
                'contentVersion' => [
                    //PropertiesSiteVersion::ID
                    //=> 'implementation-' . PropertiesSiteVersion::ID,
                    FieldsSiteVersion::COUNTRY_ISO3
                    => 'implementation-' . FieldsSiteVersion::COUNTRY_ISO3,
                    FieldsSiteVersion::FAVICON
                    => 'implementation-' . FieldsSiteVersion::FAVICON,
                    FieldsSiteVersion::LANGUAGE_ISO_939_2T
                    => 'implementation-' . FieldsSiteVersion::LANGUAGE_ISO_939_2T,
                    FieldsSiteVersion::LAYOUT
                    => 'implementation-' . FieldsSiteVersion::LAYOUT,
                    FieldsSiteVersion::LOCALE
                    => 'implementation-' . FieldsSiteVersion::LOCALE,
                    FieldsSiteVersion::LOGIN_PAGE
                    => 'implementation-' . FieldsSiteVersion::LOGIN_PAGE,
                    FieldsSiteVersion::STATUS_PAGES => [
                        '404' => [
                            'path' => 'implementation-404',
                            'type' => 'render'
                        ],
                        '401' => [
                            'path' => 'implementation-401',
                            'type' => 'redirect'
                        ],
                    ],
                    FieldsSiteVersion::THEME_NAME
                    => 'implementation-' . FieldsSiteVersion::THEME_NAME,
                    FieldsSiteVersion::TITLE
                    => 'implementation-' . FieldsSiteVersion::TITLE,
                ],
                'testActions' => [
                    'testInsertContentVersion',
                    //'testResourcePublish',
                ],
            ]
        ];
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /* @todo Write this
         * - for each content type (Container with block, Page, Site, ThemeLayout, View)
         * - Get components
         * - create content
         * - upsert content
         * - find resource and version
         */

        $createdByUserId = $this->getUserIdByRequest->__invoke(
            $request
        );

        if (empty($createdByUserId)) {
            throw new \Exception(
                'Must be valid user for implementation test'
            );
        }

        $createdReason = 'TEST IMPLEMENTATION: ' . get_class($this);

        $results = [];

        foreach ($this->tests as $testName => $test) {
            foreach ($test['testActions'] as $testAction) {
                $results = $this->$testAction(
                    $testName,
                    $test,
                    $results,
                    $createdByUserId,
                    $createdReason
                );
            }
        }

        return new JsonResponse(
            $results
        );
    }

    /**
     * @param string $testName
     * @param array  $test
     * @param array  $results
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return array
     */
    public function testInsertContentVersion(
        string $testName,
        array $test,
        array $results,
        string $createdByUserId,
        string $createdReason
    ) {
        $results[$testName]['testInsertContentVersion'] = [];
        $results[$testName]['testInsertContentVersion']['message'] = '';
        $message = '';

        if (!$test['api'][InsertContentVersion::class]) {
            $message .= InsertContentVersion::class . ' not configured. ';
        }

        if (!$test['class'][ContentVersion::class]) {
            $message .= ContentVersion::class . ' not configured. ';
        }

        if (!empty($message)) {
            $message = 'Test could not be run:' . $message;
            $results[$testName]['testInsertContentVersion']['message'] = $message;

            return $results;
        }

        /** @var ContentVersion::class $contentVersionClass */
        $contentVersionClass = $test['class'][ContentVersion::class];

        $contentVersion = new $contentVersionClass(
            'testID',
            $test['contentVersion'],
            $createdByUserId,
            $createdReason
        );

        /** @var InsertContentVersion $insertContentVersion */
        $insertContentVersion = $this->serviceContainer->get($test['api'][InsertContentVersion::class]);

        $newContentVersion = $insertContentVersion->__invoke(
            $contentVersion
        );

        $results[$testName]['testInsertContentVersion']['insertedClass']
            = get_class($contentVersion);

        $results[$testName]['testInsertContentVersion']['inserted']
            = $this->contentVersionToArray->__invoke($contentVersion);

        $results[$testName]['testInsertContentVersion']['insertResultClass']
            = get_class($newContentVersion);

        $newContentVersionArray
            = $this->contentVersionToArray->__invoke($newContentVersion);

        $results[$testName]['testInsertContentVersion']['insertResult']
            = $newContentVersionArray;

        $results[$testName]['testInsertContentVersion']['message'] = 'SUCCESS';

        $results[$testName]['contentVersion'] = $newContentVersionArray;

        return $results;
    }

    public function testFindContentVersion(string $testName, array $test, array $results)
    {

    }

    public function testResourceUpsert(string $testName, array $test, array $results)
    {

    }

    public function testResourceRepublish(string $testName, array $test, array $results)
    {

    }

    public function testFindResource(string $testName, array $test, array $results)
    {

    }
}
