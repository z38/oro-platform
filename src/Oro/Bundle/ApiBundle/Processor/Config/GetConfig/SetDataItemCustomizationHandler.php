<?php

namespace Oro\Bundle\ApiBundle\Processor\Config\GetConfig;

use Doctrine\ORM\Mapping\ClassMetadata;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Oro\Bundle\ApiBundle\Config\EntityDefinitionConfig;
use Oro\Bundle\ApiBundle\Config\EntityDefinitionFieldConfig;
use Oro\Bundle\ApiBundle\Processor\CustomizeDataItemContext;
use Oro\Bundle\ApiBundle\Processor\CustomizeDataItemProcessor;
use Oro\Bundle\ApiBundle\Processor\Config\ConfigContext;
use Oro\Bundle\ApiBundle\Util\ConfigUtil;
use Oro\Bundle\ApiBundle\Util\DoctrineHelper;

/**
 * Registers a post loading handler for the entity and all related entities.
 * It allows to customize loaded data by registering own processors for the "customize_data_item" action.
 */
class SetDataItemCustomizationHandler implements ProcessorInterface
{
    /** @var CustomizeDataItemProcessor */
    protected $customizationProcessor;

    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /**
     * @param CustomizeDataItemProcessor $customizationProcessor
     * @param DoctrineHelper             $doctrineHelper
     */
    public function __construct(
        CustomizeDataItemProcessor $customizationProcessor,
        DoctrineHelper $doctrineHelper
    ) {
        $this->customizationProcessor = $customizationProcessor;
        $this->doctrineHelper         = $doctrineHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContextInterface $context)
    {
        /** @var ConfigContext $context */

        $definition = $context->getResult();
        $this->setCustomizationHandler($definition, $context);
    }

    /**
     * @param EntityDefinitionConfig $definition
     * @param ConfigContext          $context
     */
    protected function setCustomizationHandler(EntityDefinitionConfig $definition, ConfigContext $context)
    {
        $entityClass = $context->getClassName();

        $definition->setPostSerializeHandler(
            $this->getRootCustomizationHandler(
                $context,
                $entityClass,
                $definition->getPostSerializeHandler()
            )
        );

        if ($this->doctrineHelper->isManageableEntityClass($entityClass)) {
            // we can set customization handlers for associations only for manageable entity,
            // because for other types of entities we do not have metadata
            $this->processFields(
                $context,
                $definition,
                $entityClass,
                $this->doctrineHelper->getEntityMetadataForClass($entityClass)
            );
        }
    }

    /**
     * @param ConfigContext          $context
     * @param EntityDefinitionConfig $definition
     * @param string                 $rootEntityClass
     * @param ClassMetadata          $metadata
     * @param string|null            $fieldPath
     */
    protected function processFields(
        ConfigContext $context,
        EntityDefinitionConfig $definition,
        $rootEntityClass,
        ClassMetadata $metadata,
        $fieldPath = null
    ) {
        $fields = $definition->getFields();
        foreach ($fields as $fieldName => $field) {
            $propertyPath = $field->getPropertyPath() ?: $fieldName;
            $path         = ConfigUtil::explodePropertyPath($propertyPath);
            if (count($path) === 1) {
                $this->setFieldCustomizationHandler(
                    $context,
                    $field,
                    $metadata,
                    $propertyPath,
                    $rootEntityClass,
                    $this->buildFieldPath($fieldName, $fieldPath)
                );
            } else {
                $linkedField    = array_pop($path);
                $linkedMetadata = $this->doctrineHelper->findEntityMetadataByPath($metadata->name, $path);
                if (null !== $linkedMetadata) {
                    $this->setFieldCustomizationHandler(
                        $context,
                        $field,
                        $linkedMetadata,
                        $linkedField,
                        $rootEntityClass,
                        $this->buildFieldPath($fieldName, $fieldPath)
                    );
                }
            }
        }
    }

    /**
     * @param ConfigContext               $context
     * @param EntityDefinitionFieldConfig $field
     * @param ClassMetadata               $metadata
     * @param string                      $fieldName
     * @param string                      $rootEntityClass
     * @param string                      $fieldPath
     */
    protected function setFieldCustomizationHandler(
        ConfigContext $context,
        EntityDefinitionFieldConfig $field,
        ClassMetadata $metadata,
        $fieldName,
        $rootEntityClass,
        $fieldPath
    ) {
        if ($metadata->hasAssociation($fieldName)) {
            $targetEntity = $field->getOrCreateTargetEntity();
            $targetEntity->setPostSerializeHandler(
                $this->getCustomizationHandler(
                    $context,
                    $rootEntityClass,
                    $fieldPath,
                    $metadata->getAssociationTargetClass($fieldName),
                    $targetEntity->getPostSerializeHandler()
                )
            );
            $this->processFields($context, $targetEntity, $rootEntityClass, $metadata, $fieldPath);
        }
    }

    /**
     * @param string      $fieldName
     * @param string|null $parentFieldPath
     *
     * @return string
     */
    protected function buildFieldPath($fieldName, $parentFieldPath = null)
    {
        return null !== $parentFieldPath
            ? $parentFieldPath . ConfigUtil::PATH_DELIMITER . $fieldName
            : $fieldName;
    }

    /**
     * @param ConfigContext $context
     *
     * @return CustomizeDataItemContext
     */
    protected function createCustomizationContext(ConfigContext $context)
    {
        /** @var CustomizeDataItemContext $customizationContext */
        $customizationContext = $this->customizationProcessor->createContext();
        $customizationContext->setVersion($context->getVersion());
        $customizationContext->setRequestType($context->getRequestType());

        return $customizationContext;
    }

    /**
     * @param ConfigContext $context
     * @param string        $entityClass
     * @param callable|null $previousHandler
     *
     * @return callable
     */
    protected function getRootCustomizationHandler(
        ConfigContext $context,
        $entityClass,
        $previousHandler
    ) {
        return function (array $item) use ($context, $entityClass, $previousHandler) {
            if (null !== $previousHandler) {
                $item = call_user_func($previousHandler, $item);
            }

            $customizationContext = $this->createCustomizationContext($context);
            $customizationContext->setClassName($entityClass);
            $customizationContext->setResult($item);
            $this->customizationProcessor->process($customizationContext);

            return $customizationContext->getResult();
        };
    }

    /**
     * @param ConfigContext $context
     * @param string        $rootEntityClass
     * @param string        $propertyPath
     * @param string        $entityClass
     * @param callable|null $previousHandler
     *
     * @return callable
     */
    protected function getCustomizationHandler(
        ConfigContext $context,
        $rootEntityClass,
        $propertyPath,
        $entityClass,
        $previousHandler
    ) {
        return function (array $item) use ($context, $rootEntityClass, $propertyPath, $entityClass, $previousHandler) {
            if (null !== $previousHandler) {
                $item = call_user_func($previousHandler, $item);
            }

            $customizationContext = $this->createCustomizationContext($context);
            $customizationContext->setRootClassName($rootEntityClass);
            $customizationContext->setPropertyPath($propertyPath);
            $customizationContext->setClassName($entityClass);
            $customizationContext->setResult($item);
            $this->customizationProcessor->process($customizationContext);

            return $customizationContext->getResult();
        };
    }
}
