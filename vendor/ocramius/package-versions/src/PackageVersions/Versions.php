<?php

declare(strict_types=1);

namespace PackageVersions;

/**
 * This class is generated by ocramius/package-versions, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    public const ROOT_PACKAGE_NAME = '__root__';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    public const VERSIONS          = array (
  'defuse/php-encryption' => 'v2.2.1@0f407c43b953d571421e0020ba92082ed5fb7620',
  'doctrine/annotations' => 'v1.8.0@904dca4eb10715b92569fbcd79e201d5c349b6bc',
  'doctrine/cache' => '1.10.0@382e7f4db9a12dc6c19431743a2b096041bcdd62',
  'doctrine/collections' => '1.6.4@6b1e4b2b66f6d6e49983cebfe23a21b7ccc5b0d7',
  'doctrine/common' => '2.12.0@2053eafdf60c2172ee1373d1b9289ba1db7f1fc6',
  'doctrine/dbal' => 'v2.10.1@c2b8e6e82732a64ecde1cddf9e1e06cb8556e3d8',
  'doctrine/doctrine-bundle' => '2.0.6@0ef972d3b730f975c80db9fffa4b2a0258c91442',
  'doctrine/doctrine-migrations-bundle' => '2.1.2@856437e8de96a70233e1f0cc2352fc8dd15a899d',
  'doctrine/event-manager' => '1.1.0@629572819973f13486371cb611386eb17851e85c',
  'doctrine/inflector' => '1.3.1@ec3a55242203ffa6a4b27c58176da97ff0a7aec1',
  'doctrine/instantiator' => '1.3.0@ae466f726242e637cebdd526a7d991b9433bacf1',
  'doctrine/lexer' => '1.2.0@5242d66dbeb21a30dd8a3e66bf7a73b66e05e1f6',
  'doctrine/migrations' => '2.2.1@a3987131febeb0e9acb3c47ab0df0af004588934',
  'doctrine/orm' => 'v2.7.0@4d763ca4c925f647b248b9fa01b5f47aa3685d62',
  'doctrine/persistence' => '1.3.4@ff7e08b0f814be2cd20c52dc3c8a262579376b94',
  'doctrine/reflection' => 'v1.1.0@bc420ead87fdfe08c03ecc3549db603a45b06d4c',
  'jdorn/sql-formatter' => 'v1.2.17@64990d96e0959dff8e059dfcdc1af130728d92bc',
  'lcobucci/jwt' => '3.3.1@a11ec5f4b4d75d1fcd04e133dede4c317aac9e18',
  'league/event' => '2.2.0@d2cc124cf9a3fab2bb4ff963307f60361ce4d119',
  'league/oauth2-server' => '8.0.0@e1dc4d708c56fcfa205be4bb1862b6d525b4baac',
  'league/tactician' => 'v1.0.3@d0339e22fd9252fb0fa53102b488d2c514483b8a',
  'nyholm/psr7' => '1.2.1@55ff6b76573f5b242554c9775792bd59fb52e11c',
  'ocramius/package-versions' => '1.5.1@1d32342b8c1eb27353c8887c366147b4c2da673c',
  'ocramius/proxy-manager' => '2.2.3@4d154742e31c35137d5374c998e8f86b54db2e2f',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.2@446d54b4cb6bf489fc9d75f55843658e6f25d801',
  'ramsey/uuid' => '3.9.2@7779489a47d443f845271badbdcedfe4df8e06fb',
  'sensio/framework-extra-bundle' => 'v5.5.3@98f0807137b13d0acfdf3c255a731516e97015de',
  'symfony/apache-pack' => 'v1.0.1@3aa5818d73ad2551281fc58a75afd9ca82622e6c',
  'symfony/cache' => 'v5.0.2@6e8d978878ae5de705ec9fabbb6011cc18776bc9',
  'symfony/cache-contracts' => 'v2.0.1@23ed8bfc1a4115feca942cb5f1aacdf3dcdf3c16',
  'symfony/config' => 'v5.0.2@7f930484966350906185ba0a604728f7898b7ba0',
  'symfony/console' => 'v5.0.2@fe6e3cd889ca64172d7a742a2eb058541404ef47',
  'symfony/dependency-injection' => 'v5.0.2@f9dbfbf487d08f60b1c83220edcd16559d1e40a2',
  'symfony/doctrine-bridge' => 'v5.0.2@0bdb2d31741cacacb95130d28fbac939c4d574f2',
  'symfony/dotenv' => 'v5.0.2@7e1bc9024edd9157264e388080df2533306894d3',
  'symfony/error-handler' => 'v5.0.2@460863313bd3212d7c38e1b40602cbcfeeeea4a5',
  'symfony/event-dispatcher' => 'v5.0.2@7b738a51645e10f864cc25c24d232fb03f37b475',
  'symfony/event-dispatcher-contracts' => 'v2.0.1@af23c2584d4577d54661c434446fb8fbed6025dd',
  'symfony/filesystem' => 'v5.0.2@1d71f670bc5a07b9ccc97dc44f932177a322d4e6',
  'symfony/finder' => 'v5.0.2@17874dd8ab9a19422028ad56172fb294287a701b',
  'symfony/flex' => 'v1.6.0@952f45d1c5077e658cb16a61d11603bee873f968',
  'symfony/framework-bundle' => 'v5.0.2@36e51776b231d8e224da4ce4c60079540acd1c55',
  'symfony/http-foundation' => 'v5.0.2@5dd7f6be6e62d86ba6f3154cf40e78936367978b',
  'symfony/http-kernel' => 'v5.0.2@00ce30602f3f690e66a63c327743d7b26c723b2e',
  'symfony/mime' => 'v5.0.2@0e6a4ced216e49d457eddcefb61132173a876d79',
  'symfony/orm-pack' => 'v1.0.7@c57f5e05232ca40626eb9fa52a32bc8565e9231c',
  'symfony/polyfill-intl-idn' => 'v1.13.1@6f9c239e61e1b0c9229a28ff89a812dc449c3d46',
  'symfony/polyfill-mbstring' => 'v1.13.1@7b4aab9743c30be783b73de055d24a39cf4b954f',
  'symfony/polyfill-php73' => 'v1.13.1@4b0e2222c55a25b4541305a053013d5647d3a25f',
  'symfony/psr-http-message-bridge' => 'v1.3.0@9d3e80d54d9ae747ad573cad796e8e247df7b796',
  'symfony/routing' => 'v5.0.2@120c5fa4f4ef5466cbb510ece8126e0007285301',
  'symfony/service-contracts' => 'v2.0.1@144c5e51266b281231e947b51223ba14acf1a749',
  'symfony/stopwatch' => 'v5.0.2@d410282956706e0b08681a5527447a8e6b6f421e',
  'symfony/var-dumper' => 'v5.0.2@d7bc61d5d335fa9b1b91e14bb16861e8ca50f53a',
  'symfony/var-exporter' => 'v5.0.2@1b9653e68d5b701bf6d9c91bdd3660078c9f4f28',
  'symfony/yaml' => 'v5.0.2@847661e77afa48d99ecfa508e8b60f0b029a19c0',
  'zendframework/zend-code' => '3.4.1@268040548f92c2bfcba164421c1add2ba43abaaa',
  'zendframework/zend-eventmanager' => '3.2.1@a5e2583a211f73604691586b8406ff7296a946dd',
  'phpdocumentor/reflection-common' => '2.0.0@63a995caa1ca9e5590304cd845c15ad6d482a62a',
  'phpdocumentor/reflection-docblock' => '4.3.4@da3fd972d6bafd628114f7e7e036f45944b62e9c',
  'phpdocumentor/type-resolver' => '1.0.1@2e32a6d48972b2c1976ed5d8967145b6cec4a4a9',
  'phpspec/php-diff' => 'v1.1.0@0464787bfa7cd13576c5a1e318709768798bec6a',
  'phpspec/phpspec' => '6.1.1@486aaa736e9e24f3e22a6545f6affb88f98e2602',
  'phpspec/prophecy' => '1.10.1@cbe1df668b3fe136bcc909126a0f529a78d4cbbc',
  'sebastian/comparator' => '3.0.2@5de4fc177adf9bce8df98d8d141a7559d7ccf6da',
  'sebastian/diff' => '3.0.2@720fcc7e9b5cf384ea68d9d930d480907a0c1a29',
  'sebastian/exporter' => '3.1.2@68609e1261d215ea5b21b7987539cbfbe156ec3e',
  'sebastian/recursion-context' => '3.0.0@5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8',
  'symfony/process' => 'v5.0.2@ea2dc31b59d63abd9bc2356ac72eb7b3f3469f0e',
  'webmozart/assert' => '1.6.0@573381c0a64f155a0d9a23f4b0c797194805b925',
  'zircote/swagger-php' => '3.0.3@c86386bd623ffad6f7e6f9269bf51d42d2797012',
  'paragonie/random_compat' => '2.*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-ctype' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-iconv' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-php72' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-php71' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-php70' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  'symfony/polyfill-php56' => '*@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
  '__root__' => 'dev-devjoshua@7d39c7a2a7d89124b297d5ea8d91fd7b9ad51bf1',
);

    private function __construct()
    {
    }

    /**
     * @throws \OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new \OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
