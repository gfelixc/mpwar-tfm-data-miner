<?php

namespace Mpwar\DataMiner\Test\Behaviour;

use AntPack\DataTypes\Common\Language;
use Mockery\Mock;
use Mpwar\DataMiner\Domain\Author;
use Mpwar\DataMiner\Domain\CreatedAt;
use Mpwar\DataMiner\Domain\DocumentFactory;
use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\KeywordCollection;
use Mpwar\DataMiner\Domain\LinkCollection;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\Service\SocialNetwork\TwitterParserService;
use Mpwar\DataMiner\Domain\Source;
use Mpwar\DataMiner\Domain\TextCollection;
use Mpwar\DataMiner\Test\Infrastructure\AuthorStub;
use Mpwar\DataMiner\Test\Infrastructure\CreatedAtStub;
use Mpwar\DataMiner\Test\Infrastructure\DocumentIdStub;
use Mpwar\DataMiner\Test\Infrastructure\DocumentStub;
use Mpwar\DataMiner\Test\Infrastructure\HashtagCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\HashtagStub;
use Mpwar\DataMiner\Test\Infrastructure\ImageCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\ImageStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\DataMiner\Test\Infrastructure\LanguageStub;
use Mpwar\DataMiner\Test\Infrastructure\LinkCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\LinkStub;
use Mpwar\DataMiner\Test\Infrastructure\LinkTypeStub;
use Mpwar\DataMiner\Test\Infrastructure\LinkUrlStub;
use Mpwar\DataMiner\Test\Infrastructure\ServiceRecordStub;
use Mpwar\DataMiner\Test\Infrastructure\SourceStub;
use Mpwar\DataMiner\Test\Infrastructure\TextCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\TextStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class TwitterParserServiceTest extends UnitTestCase
{
    /** @var  Mock|DocumentFactory */
    private $documentFactory;
    /** @var  TwitterParserService */
    private $twitterParserService;

    public function setUp()
    {
        parent::setUp();

        $this->documentFactory      = $this->mock(DocumentFactory::class);
        $this->twitterParserService = new TwitterParserService($this->documentFactory);
    }

    /**
     * @test
     */
    public function happyPath()
    {
        $documentId        = DocumentIdStub::random();
        $source            = SourceStub::create(250075927172759552, 'twitter');
        $keyword           = KeywordStub::create('hooli');
        $serviceRecord     = ServiceRecordStub::fromTwitter();
        $keywordCollection = KeywordCollectionStub::create($keyword);
        $link              = LinkStub::create(
            LinkTypeStub::create(LinkType::DIRECT),
            LinkUrlStub::create('https://twitter.com/sean_cummings/status/250075927172759552')
        );
        $linkCollection    = LinkCollectionStub::create($link);
        $hashtag           = HashtagStub::create('freebandnames');
        $hashtagCollection = HashtagCollectionStub::create($hashtag);
        $text              = TextStub::create('Aggressive Ponytail #freebandnames');
        $textCollection    = TextCollectionStub::create($text);
        $image             = ImageStub::create(
            LinkUrlStub::create('http://a0.twimg.com/profile_images/2359746665/1v6zfgqo8g0d3mk7ii5s_normal.jpeg'),
            TextStub::create('Profile image')
        );
        $imageCollection   = ImageCollectionStub::create($image);
        $language          = LanguageStub::create('en');
        $author            = AuthorStub::create('Sean Cummings', 'LA, CA');
        $createdAt         = CreatedAtStub::create('2012-09-24T03:35:21+00:00');

        $this->documentFactory()->shouldReceive('createDocumentId')->once()->with(\Mockery::type('string'))->andReturn(
            $documentId
        );
        $this->documentFactory()->shouldReceive('createSource')->once()->with(250075927172759552, 'twitter')->andReturn(
            $source
        );
        $this->documentFactory()->shouldReceive('createLanguage')->once()->with('en')->andReturn($language);
        $this->documentFactory()->shouldReceive('createKeyword')->once()->with('hooli')->andReturn($keyword);
        $this->documentFactory()->shouldReceive('createKeywordCollection')->once()->with(equalTo($keyword))->andReturn(
            $keywordCollection
        );
        $this->documentFactory()->shouldReceive('createAuthor')->once()->with('Sean Cummings', 'LA, CA')->andReturn(
            $author
        );

        $this->documentFactory()->shouldReceive('createLink')->once()->with(
            'direct',
            'https://twitter.com/sean_cummings/status/250075927172759552'
        )->andReturn($link);
        $this->documentFactory()->shouldReceive('createLinkCollection')->once()->with(equalTo($link))->andReturn(
            $linkCollection
        );
        $this->documentFactory()->shouldReceive('createHashtag')->once()->with('freebandnames')
             ->andReturn($hashtag);
        $this->documentFactory()->shouldReceive('createHashtagCollection')->once()->with(equalTo($hashtag))->andReturn(
            $hashtagCollection
        );
        $this->documentFactory()->shouldReceive('createText')->once()->with('Aggressive Ponytail #freebandnames')
             ->andReturn($text);
        $this->documentFactory()->shouldReceive('createTextCollection')->once()->with(equalTo($text))->andReturn(
            $textCollection
        );

        $this->documentFactory()->shouldReceive('createImage')->once()->with(
            'http://a0.twimg.com/profile_images/2359746665/1v6zfgqo8g0d3mk7ii5s_normal.jpeg',
            'Profile image'
        )->andReturn($image);
        $this->documentFactory()->shouldReceive('createImageCollection')->once()->with(equalTo($image))->andReturn(
            $imageCollection
        );
        $this->documentFactory()->shouldReceive('createCreatedAt')->once()->with('2012-09-24T03:35:21+00:00')
             ->andReturn(
                 $createdAt
             );

        $documentExpected = DocumentStub::create(
            $documentId,
            $source,
            $language,
            $keywordCollection,
            $author,
            $linkCollection,
            $hashtagCollection,
            $textCollection,
            $imageCollection,
            $createdAt
        );

        $this->documentFactory()->shouldReceive('createDocument')->once()->with(
            DocumentId::class,
            Source::class,
            Language::class,
            KeywordCollection::class,
            Author::class,
            LinkCollection::class,
            HashtagCollection::class,
            TextCollection::class,
            ImageCollection::class,
            CreatedAt::class
        )->andReturn($documentExpected);

        $document = $this->twitterParserService->parse($serviceRecord, $keyword);

        $this->assertEquals($documentExpected, $document);
    }

    /**
     * @return Mock|DocumentFactory
     */
    public function documentFactory()
    {
        return $this->documentFactory;
    }
}

