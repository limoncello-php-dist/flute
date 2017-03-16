<?php namespace Limoncello\Flute;

/**
 * Copyright 2015-2017 info@neomerx.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Doctrine\DBAL\Connection;
use Limoncello\Flute\Adapters\Repository;
use Limoncello\Flute\Api\ModelsData;
use Limoncello\Flute\Contracts\Adapters\FilterOperationsInterface;
use Limoncello\Flute\Contracts\FactoryInterface;
use Limoncello\Flute\Contracts\I18n\TranslatorInterface as T;
use Limoncello\Flute\Contracts\Models\ModelSchemesInterface;
use Limoncello\Flute\Contracts\Models\PaginatedDataInterface;
use Limoncello\Flute\Contracts\Models\RelationshipStorageInterface;
use Limoncello\Flute\Contracts\Schema\JsonSchemesInterface;
use Limoncello\Flute\Encoder\Encoder;
use Limoncello\Flute\I18n\Translator;
use Limoncello\Flute\Models\ModelStorage;
use Limoncello\Flute\Models\PaginatedData;
use Limoncello\Flute\Models\RelationshipStorage;
use Limoncello\Flute\Models\TagStorage;
use Limoncello\Flute\Schema\JsonSchemes;
use Neomerx\JsonApi\Contracts\Factories\FactoryInterface as JsonApiFactoryInterface;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Exceptions\ErrorCollection;
use Neomerx\JsonApi\Factories\Factory as JsonApiFactory;

/**
 * @package Limoncello\Flute
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Factory implements FactoryInterface
{
    /**
     * @var JsonApiFactoryInterface
     */
    private $jsonApiFactory = null;

    /**
     * @return JsonApiFactoryInterface
     */
    public function getJsonApiFactory()
    {
        if ($this->jsonApiFactory === null) {
            $this->jsonApiFactory = new JsonApiFactory();
        }

        return $this->jsonApiFactory;
    }

    /**
     * @param mixed $data
     *
     * @return PaginatedDataInterface
     */
    public function createPaginatedData($data)
    {
        return new PaginatedData($data);
    }

    /**
     * @inheritdoc
     */
    public function createErrorCollection()
    {
        return new ErrorCollection();
    }

    /**
     * @inheritdoc
     */
    public function createRelationshipStorage()
    {
        return new RelationshipStorage($this);
    }

    /**
     * @inheritdoc
     */
    public function createModelStorage(ModelSchemesInterface $modelSchemes)
    {
        return new ModelStorage($modelSchemes);
    }

    /**
     * @inheritdoc
     */
    public function createTagStorage()
    {
        return new TagStorage();
    }

    /**
     * @inheritdoc
     */
    public function createModelsData(
        PaginatedDataInterface $paginatedData,
        RelationshipStorageInterface $relationshipStorage = null
    ) {
        return new ModelsData($paginatedData, $relationshipStorage);
    }

    /**
     * @inheritdoc
     */
    public function createTranslator()
    {
        return new Translator();
    }

    /**
     * @inheritdoc
     */
    public function createRepository(
        Connection $connection,
        ModelSchemesInterface $modelSchemes,
        FilterOperationsInterface $filterOperations,
        T $translator
    ) {
        return new Repository($connection, $modelSchemes, $filterOperations, $translator);
    }

    /**
     * @inheritdoc
     */
    public function createJsonSchemes(array $schemes, ModelSchemesInterface $modelSchemes)
    {
        return new JsonSchemes($this->getJsonApiFactory(), $schemes, $modelSchemes);
    }

    /**
     * @inheritdoc
     */
    public function createEncoder(JsonSchemesInterface $schemes, EncoderOptions $encoderOptions = null)
    {
        return new Encoder($this->getJsonApiFactory(), $schemes, $encoderOptions);
    }
}
