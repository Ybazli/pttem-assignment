<?php

    namespace App\DataProvider;

    use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
    use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
    use App\Entity\Product as ProductORM;
    use App\Document\Product as ProductODM;

    final class BlogPostItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
    {
        public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
        {
            switch ($_ENV['APP_DB']){
                case 'mongodb':
                    return ProductODM::class === $resourceClass;
                    break;
                default:
                    return ProductORM::class === $resourceClass;
                    break;
            }

        }

        public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
        {

        }
    }