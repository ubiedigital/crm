$1 bin/console fos:js-routing:dump --env=$2 &&
$1 bin/console oro:localization:dump --env=$2 &&
$1 bin/console oro:assets:install --env=$2 &&
$1 bin/console assetic:dump --env=$2 &&
$1 bin/console oro:requirejs:build --env=$2 &&
$1 bin/console cache:warmup --env=$2 &&
$1 bin/console oro:translation:load --env=$2
