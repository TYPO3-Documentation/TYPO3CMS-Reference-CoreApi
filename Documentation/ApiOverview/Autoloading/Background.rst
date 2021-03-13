.. include:: /Includes.rst.txt
.. index:: 
   Autoloader; ComposerClassLoader
   ClassLoader
.. _composer-class-loader:

===================
ComposerClassLoader
===================

Integrating Composer class loader into TYPO3 CMS
================================================

In our efforts to make the TYPO3 CMS system faster and closer oriented
to common PHP standard systems, we looked into the integration of the
class loader that is used by all composer-based projects. We consider
this functionality a crucial feature for the future of TYPO3 CMS on the
base level, but also as a dramatic increase of the overall performance
of every request inside TYPO3 CMS.

Understanding the TYPO3 CMS class loader
========================================

The TYPO3 class loader is instantiated within the TYPO3 CMS Bootstrap at
a very early point. It does a lot of logic (checking :file:`ext_autoload.php`,
:file:`ClassAliasMap.php), and caches this logic away on a per-class basis by
default in :file:`typo3temp/Cache/` to store all information for a class. This
information contains: The full path to the class, the namespaced class
name itself and possible class aliases.

The latter part looks into all extensions and checks the
:file:`Migrations/ClassAliasMap.php` file for any possible “legacy class” that
could be used (e.g. t3lib_extmgm). This way, all extensions still using
non-namespaced class that are shipped with the TYPO3 core are still made
available.

The information is stored in a SimpleFileBackend via the built-in
Caching Framework by default. At the early stage of the bootstrap
process some classes need to be included manually as the whole TYPO3
core engine has not been loaded yet. This is done for all PHP classes in
use, which may result in 500+ files inside :file:`typo3temp/Cache` which are
created one by one on an initial request with no caches set up. This is
done by intention on a per-file-basis during runtime as a cache file is
only created if a PHP class is requested to be instantiated. On a second
hit, the caching framework does not create the cache files, but fetches
one by one for each class used in the request via a separate
:php:`file_get_contents()` call.

When debugging the TYPO3 CMS system on an initial request, there are a
lot of :file:`file_get_contents()` and :file:`file_put_contents()` calls to
store and fetch this information. This is quite a lot of overhead for loading
PHP classes. Even without a lot of class aliases (e.g. in CMS7) this
overhead of writing / storing the file caches still exists. Some
overhead however is already taken care, especially if a class is loaded
which is shipped with the core and no class alias is used.

This is all built in a way so a lot of backwards-compatibility can be
ensured.

Understanding the Composer class loader
=======================================

Compared to the TYPO3 CMS class loader, the composer class loader
concept differs in the following major points:

Caching on build stage
----------------------

When setting up a project, like a TYPO3 CMS project, Composer checks the
main composer.json of a project and builds a static file with all PSR-4
prefixes defined in that json file. Unless in a development environment
or when updating the source, this file does not need to be rebuilt as
the PHP classes of the loaded packages won’t change in a regular
instance. This way all classes available inside TYPO3 CMS are always
available to the class loader.

Using PSR-4 compatible prefix-based resolving
---------------------------------------------

Instead of looking up every single class and caching the information
away, composer works on a “prefix”-based resolution. As an example, the
Composer class loader only needs to know that all PHP classes starting
with TYPO3\CMS\Core are located within typo3/sysext/core/Classes. The
rest is done by a simple resolution to include the necessary PHP class
files. This means that the information to be cached away is only the
list of available namespace-prefixes. All classes inside the TYPO3 CMS
Core are PSR-4 compatible since TYPO3 CMS 6.0 already.

The definition of these prefixes is set inside the composer.json of each
package or distribution / project. In the TYPO3 CMS Core, every system
extension defined these namespace prefixes already since TYPO3 CMS 7.1
and TYPO3 CMS 6.2.10.

Autoloading developer-specific data differently
-----------------------------------------------

The composer class loader checks the :file:`composer.json` for a development
installation differently, including for example unit and functional tests
separately to the rest of the installation. The static map with all
namespaces are thus different when using Composer with `composer
install` or `composer install --no-dev`.

Integration Approach
====================

The Composer class loader is injected inside the Bootstrap process of
TYPO3 CMS and registered before the TYPO3 class loader. This means that
a lookup on a class name is first checked via the Composer logic, and if
none found, the regular TYPO3 class loader takes over.

The support for class aliases is quite important for TYPO3 CMS, but is
not supported by Composer by default. There is a separate Composer
package created by Helmut Hummel (available on `GitHub
<https://github.com/helhum/class-alias-loader>`_) which serves as a facade
to the Composer class loader and creates not just the information for
the prefixes but also the available class aliases for a class and loads
them as well.

The necessary information about the “which namespaced classes can be
found at which place” is created before every release and shipped inside
the :file:`typo3_src` directory. The generated class information is available
under :file:`typo3/contrib/vendor/composer/`. For TYPO3 installations that are
set up with composer, the TYPO3 bootstrap checks
:file:`Packages/Libraries/autoload.php` first which can be shipped with any
composer-based project and include many more PHP Composer packages than
just TYPO3 extensions. To ensure maximum backwards-compatibility, the
option to load from :file:`Packages/Library/autoload.php` instead of the shipped
"required-core-packages-only" needs to be activated via an environment
variable called :php:`TYPO3_COMPOSER_AUTOLOAD` which needs to be set on
server-side level.

If the composer-based logic is not used in some legacy cases (for
extensions etc), the usual TYPO3 class loader comes into play and does
the same logic as before.

Project setup and extension considerations
==========================================

If you already use Composer to set up your project, and the
composer.json and their extensions ship a valid composer.json, the
Composer class loader generates the valid PSR-4 cache file with all
prefixes on installation and update. Running "composer update" will
automatically re-generate the PSR-4 cache file.

The Composer class loader also supports PSR-0 and static inclusion of
files, which can be used as well.

As a base line: Any regular installation will see a proper speed
improvement after the update to the Composer class loader.
