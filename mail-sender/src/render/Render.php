<?php


namespace MailSender\render;

use MailSender\Path;
use MailSender\tools\StringTool;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;


class Render
{

    /**
     * Return the rendered HTML with the provided template and data.
     * The .twig extension can be forget for $template argument.
     *
     * @param        $template
     * @param        $data
     *
     * @param object $settings
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function render($template, $data, object $settings)
    {
        $loader = new FilesystemLoader(Path::TEMPLATES);

        $template = self::getTemplateFile($template);

        //$settings = $settings;

        $twig = new Environment(
            $loader, [
                       'debug' => self::getDebug(
                           $settings->global->environment
                       ),
                       'cache' => false,
                       // no need of cache for mails : they are all different.
                   ]
        );

        return $twig->render($template, $data);
    }

    /**
     * Return the file's name of the template provided.
     * Let the possibility of forget the .twig extension.
     *
     * Add .twig at the end if have not.
     *
     * @param string $template
     *
     * @return string
     */
    protected static function getTemplateFile(string $template): string
    {
        if (StringTool::endsWith($template, '.twig')) {
            return $template;
        }
        return $template . '.twig';
    }

    /**
     * Return the twig's debug value in terms of environment.
     * Return TRUE if in dev environment.
     * Return FALSE if not in dev environment.
     *
     * @param string $environment
     *
     * @return bool
     */
    protected static function getDebug(string $environment): bool
    {
        if (!empty($environment) && $environment === 'dev') {
            return true;
        }
        Return false;
    }


}