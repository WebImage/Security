[]()# Security Framework
Security framework for assigning roles and permissions to "things" (i.e. SecurityEntitities) 

The framework consists of security entities and the roles and permissions that can be assigned to that security entity.

Implementing libraries should implement:
- A role provider that implements **RoleProviderInterface**
- A permission provider that implements **PermissionProviderInterface**
- A class that represents the "thing" with roles and implmenets **SecurityEntity**, which allows these items to be generically attached to the security entity.
- A factory that implements **EntityFactoryInterface** and creates a **SecurityEntity**-based object from the actual implementation of that object, e.g. a UserEntityFactory might return a UserEntity object based on a User object or ID.

## Management
SecurityManager - A centralized manager for security entities and their roles and permissions.
SecurityManagerAwareInterface
SecurityManagerAwareTrait
EntityServiceInterface


## Identifiables
- NameableIdentityInterface
- AbstractIdentifiable - Identifiable things with an ID and name, e.g. Role or Permission
  - Permission - A single permission
  - Role - A single role
- QId

# Entities
- AbstractSecurityEntity.php - Represents a security entity - a "thing" that can have permissions and perform actions.
  - Includes QId (qualified ID), addRole, removeRole, inRole, getRoles
- EntityFactoryResolver.php - Each entity type will have its own namespace that can be resolved to a factory

## Roles
- RoleProviderAwareTrait
- RoleProviderAwareInterface - No usages found, but may be used by implementer
- RoleProviderInterface - Provides roles
- PermissionProviderInterface

## Entity
SecurityEntityInterface

## Exceptions
DuplicatePermissionException
DuplicateRoleException
InvalidEntityException
InvalidPermissionException
InvalidRoleException

## Unused?
EntityRoleProviderAwareInterface - no usages
EntityRoleProviderAwareTrait - no usages