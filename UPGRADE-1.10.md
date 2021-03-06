UPGRADE FROM 1.9 to 1.10
========================

####DashboardBundle:
- Class `Oro\Bundle\DashboardBundle\Provider\Converters\FilterDateTimeRangeConverter` was renamed to `Oro\Bundle\DashboardBundle\Provider\Converters\FilterDateRangeConverter`. Service was not renamed.
- Added new class `Oro\Bundle\DashboardBundle\Provider\Converters\FilterDateTimeRangeConverter`.

####SecurityBundle
- `Oro\Bundle\SecurityBundle\Acl\Extension\EntityMaskBuilder` - removed all constants for masks and their groups.
- `Oro\Bundle\SecurityBundle\Acl\Extension\EntityMaskBuilder` - now allow custom Permissions (see [permissions.md](./src/Oro/Bundle/SecurityBundle/Resources/doc/permissions.md)
- `Oro\Bundle\SecurityBundle\Acl\Extension\EntityAclExtension` - now allow custom Permissions (see [permissions.md](./src/Oro/Bundle/SecurityBundle/Resources/doc/permissions.md)
- `Oro\Bundle\SecurityBundle\Acl\Extension\MaskBuilder` - added new public methods: `hasMask(string $name)`, `getMask(string $name)`.
- `Oro\Bundle\SecurityBundle\Acl\Voter\AclVoter` - added new public method - `setPermissionManager(PermissionManager $permissionManager)`.
- Constructor for `Oro\Bundle\SecurityBundle\Acl\Extension\EntityAclExtension` changed. New arguments: `PermissionManager $permissionManager, AclGroupProviderInterface $groupProvider`
- Constructor for `Oro\Bundle\SecurityBundle\Acl\Extension\EntityMaskBuilder` changed. New arguments: `int $identity, array $permissions`
- Added command for loading permissions configuration `Oro\Bundle\SecurityBundle\Command\LoadPermissionConfigurationCommand` (`security:permission:configuration:load`) - this command added to install and update platform scripts.
- Added migration `Oro\Bundle\SecurityBundle\Migrations\Schema\LoadBasePermissionsQuery` for loading to DB base permissions ('VIEW', 'CREATE', 'EDIT', 'DELETE', 'ASSIGN', 'SHARE').
- Added migration `Oro\Bundle\SecurityBundle\Migrations\Schema\v1_1\UpdateAclEntriesMigrationQuery` for updating ACL Entries to use custom Permissions.
- Added `acl_permission` twig extension - allows get `Permission` by `AclPermission`.
- Added third parameter `$byCurrentGroup` to `Oro\Bundle\SecurityBundle\Acl\Extension\AclExtensionInterface::getPermissions` for getting permissions only for current application group name. Updated same method in `Oro\Bundle\SecurityBundle\Acl\Extension\ActionAclExtension` and `Oro\Bundle\SecurityBundle\Acl\Extension\EntityAclExtension`.

####WorkflowBundle
- Class `Oro\Bundle\WorkflowBundle\Exception\ActionException` marked as deprecated. Use `Oro\Component\Action\Exception\ActionException` instead.
- Class `Oro\Bundle\WorkflowBundle\Exception\AssemblerException` marked as deprecated. Use `Oro\Component\Action\Exception\AssemblerException` instead.
- Class `Oro\Bundle\WorkflowBundle\Exception\InvalidParameterException` marked as deprecated. Use `Oro\Component\Action\Exception\InvalidParameterException` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\AbstractAssembler` marked as deprecated. Use `Oro\Component\Action\Model\AbstractAssembler` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\AbstractStorage` marked as deprecated. Use `Oro\Component\Action\Model\AbstractStorage` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\AbstractAction` marked as deprecated. Use `Oro\Component\Action\Action\AbstractAction` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\AbstractDateAction` marked as deprecated. Use `Oro\Component\Action\Action\AbstractDateAction` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\ActionAssembler` marked as deprecated. Use `Oro\Component\Action\Action\ActionAssembler` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\ActionFactory` marked as deprecated. Use `Oro\Component\Action\Action\ActionFactory` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\ActionInterface` marked as deprecated. Use `Oro\Component\Action\Action\ActionInterface` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\AssignActiveUser` marked as deprecated. Use `Oro\Component\Action\Action\AssignActiveUser` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\AssignConstantValue` marked as deprecated. Use `Oro\Component\Action\Action\AssignConstantValue` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\AssignValue` marked as deprecated. Use `Oro\Component\Action\Action\AssignValue` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CallMethod` marked as deprecated. Use `Oro\Component\Action\Action\CallMethod` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\Configurable` marked as deprecated. Use `Oro\Component\Action\Action\Configurable` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CopyTagging` marked as deprecated. Use `Oro\Bundle\TagBundle\Workflow\Action\CopyTagging` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CreateDate` marked as deprecated. Use `Oro\Component\Action\Action\CreateDate` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CreateDateTime` marked as deprecated. Use `Oro\Component\Action\Action\CreateDateTime` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CreateEntity` marked as deprecated. Use `Oro\Component\Action\Action\CreateEntity` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\CreateObject` marked as deprecated. Use `Oro\Component\Action\Action\CreateObject` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\EventDispatcherAwareActionInterface` marked as deprecated. Use `Oro\Component\Action\Action\EventDispatcherAwareActionInterface` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\FlashMessage` marked as deprecated. Use `Oro\Component\Action\Action\FlashMessage` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\FormatName` marked as deprecated. Use `Oro\Bundle\ActionBundle\Action\FormatName` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\FormatString` marked as deprecated. Use `Oro\Component\Action\Action\FormatString` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\Redirect` marked as deprecated. Use `Oro\Component\Action\Action\Redirect` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\RemoveEntity` marked as deprecated. Use `Oro\Component\Action\Action\RemoveEntity` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\RequestEntity` marked as deprecated. Use `Oro\Component\Action\Action\RequestEntity` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\TranslateAction` marked as deprecated. Use `Oro\Component\Action\Action\TranslateAction` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\Traverse` marked as deprecated. Use `Oro\Component\Action\Action\Traverse` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\TreeExecutor` marked as deprecated. Use `Oro\Component\Action\Action\TreeExecutor` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Action\UnsetValue` marked as deprecated. Use `Oro\Component\Action\Action\UnsetValue` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Attribute` marked as deprecated. Use `Oro\Component\Action\Model\Attribute` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\AttributeGuesser` marked as deprecated. Use `Oro\Component\Action\Model\AttributeGuesser` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\AttributeManager` marked as deprecated. Use `Oro\Component\Action\Model\AttributeManager` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Condition\AbstractCondition` marked as deprecated. Use `Oro\Component\Action\Condition\AbstractCondition` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Condition\Configurable` marked as deprecated. Use `Oro\Component\Action\Condition\Configurable` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\ConfigurationPass\ReplacePropertyPath` marked as deprecated. Use `Oro\Bundle\ActionBundle\Model\ConfigurationPass\ReplacePropertyPath` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\ContextAccessor` marked as deprecated. Use `Oro\Component\Action\Model\ContextAccessor` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Event\ExecuteActionEvent` marked as deprecated. Use `Oro\Component\Action\Event\ExecuteActionEvent` instead.
- Class `Oro\Bundle\WorkflowBundle\Model\Event\ExecuteActionEvents` marked as deprecated. Use `Oro\Component\Action\Event\ExecuteActionEvents` instead.
- `Oro\Bundle\WorkflowBundle\Event\ExecuteActionEvents::HANDLE_BEFORE` is deprecated. Use `Oro\Component\Action\Event\ExecuteActionEvents::HANDLE_BEFORE` instead.
- `Oro\Bundle\WorkflowBundle\Event\ExecuteActionEvents::HANDLE_AFTER` is deprecated. Use `Oro\Component\Action\Event\ExecuteActionEvents::HANDLE_AFTER` instead.
- Service `oro_workflow.action_assembler` is deprecated. Use `oro_action.function_assembler` instead.
- Service `oro_workflow.attribute_guesser` is deprecated. Use `oro_action.attribute_guesser` instead.
- Service `oro_workflow.context_accessor` is deprecated. Use `oro_action.context_accessor` instead.
- Service `oro_workflow.action_factory` is deprecated. Use `oro_action.function_factory` instead.
- Service `oro_workflow.configuration_pass.replace_property_path` is deprecated. Use `oro_action.configuration_pass.replace_property_path` instead.
