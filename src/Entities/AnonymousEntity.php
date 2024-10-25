<?php
/**
 * An anonymous security entity which does not have any roles or permissions
 */
namespace WebImage\Security;

use WebImage\Security\QId;
use WebImage\Security\Role;
use WebImage\Security\SecurityEntityInterface;

class AnonymousEntity implements SecurityEntityInterface
{
	private string $reason;
	public function __construct(string $reason='Anonymous')
	{
		$this->reason = $reason;
	}

	public function getReason(): string
	{
		return $this->reason;
	}

	public function getQId(): QId
	{
		return new QId('anonymous', '0');
	}

	public function addRole(string $role): void {}

	public function removeRole(string $role): void {}

	public function inRole(string $role): bool
	{
		return false;
	}

	public function getRoles(): array
	{
		return [];
	}

	public function canDo(string $permission): bool
	{
		return false;
	}

	public function canDoAll(array $permissions): bool
	{
		return false;
	}

	public function canDoAny(array $permissions): bool
	{
		return false;
	}
}
