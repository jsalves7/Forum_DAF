<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerWu5JlXZ\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerWu5JlXZ/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerWu5JlXZ.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerWu5JlXZ\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerWu5JlXZ\App_KernelDevDebugContainer([
    'container.build_hash' => 'Wu5JlXZ',
    'container.build_id' => '22938b95',
    'container.build_time' => 1579624946,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerWu5JlXZ');
