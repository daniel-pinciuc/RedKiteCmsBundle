<?php
/**
 * This file is part of the RedKiteCmsBunde Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) RedKite Labs <webmaster@redkite-labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace RedKiteLabs\RedKiteCmsBundle\Core\ThemesCollectionWrapper;

use RedKiteLabs\ThemeEngineBundle\Core\ThemesCollection\AlThemesCollection;
use RedKiteLabs\RedKiteCmsBundle\Core\Content\Template\AlTemplateManager;
use RedKiteLabs\RedKiteCmsBundle\Core\ThemesCollectionWrapper\Exception\TemplateNotFoundException;
use RedKiteLabs\RedKiteCmsBundle\Core\ThemesCollectionWrapper\Exception\ThemeNotFoundException;

/**
 * Handles the themes collection object to provide an easy way to deal with themes
 * and templates
 *
 * @author RedKite Labs <webmaster@redkite-labs.com>
 */
class AlThemesCollectionWrapper
{
    private $themes;
    private $templateManager;

    /**
     * Constructor
     *
     * @param \RedKiteLabs\ThemeEngineBundle\Core\ThemesCollection\AlThemesCollection $themes
     * @param \RedKiteLabs\RedKiteCmsBundle\Core\Content\Template\AlTemplateManager   $templateManager
     */
    public function __construct(AlThemesCollection $themes, AlTemplateManager $templateManager)
    {
        $this->themes = $themes;
        $this->templateManager = $templateManager;
    }

    /**
     * Returns the managed themes collection
     *
     * @return \RedKiteLabs\ThemeEngineBundle\Core\ThemesCollection\AlThemesCollection
     */
    public function getThemesCollection()
    {
        return $this->themes;
    }

    /**
     * Returns the managed template manager
     *
     * @return \RedKiteLabs\RedKiteCmsBundle\Core\Content\Template\AlTemplateManager
     */
    public function getTemplateManager()
    {
        return $this->templateManager;
    }

    /**
     * Returns the theme from its name
     *
     * @param  string                                            $themeName
     * @return \RedKiteLabs\ThemeEngineBundle\Core\Theme\AlTheme
     */
    public function getTheme($themeName)
    {
        $theme = $this->themes->getTheme($themeName);
        if (null === $theme) {
            $exception = array(
                'message' => 'The theme %theme_name% has not been loaded. You should check out the theme\'s configuration to fix the problem. If you want to use another theme, edit manually the app/Resources/.active_theme hidden file, changing the current theme name with the one you want to use.',
                'parameters' => array(
                    '%theme_name%' => $themeName,
                ),
            );
            throw new ThemeNotFoundException(json_encode($exception));
        }

        return $theme;
    }

    /**
     * Returns the template from theme name and the template name
     *
     * @param  string                                                  $themeName
     * @param  string                                                  $templateName
     * @return \RedKiteLabs\ThemeEngineBundle\Core\Template\AlTemplate
     */
    public function getTemplate($themeName, $templateName)
    {
        $theme = $this->getTheme($themeName);

        return $theme->getTemplate($templateName);
    }

    /**
     * Assigns the template retrieved from theme name and the template name to the template manager
     *
     * @param  string                                                                $themeName
     * @param  string                                                                $templateName
     * @return \RedKiteLabs\RedKiteCmsBundle\Core\Content\Template\AlTemplateManager
     * @throws TemplateNotFoundException
     */
    public function assignTemplate($themeName, $templateName)
    {
        $template = $this->getTemplate($themeName, $templateName);
        if (null === $template) {
            $exception = array(
                'message' => 'exception_template_not_found',
                'parameters' => array(
                    '%templateName%' => $templateName,
                    '%themeName%' => $themeName,
                ),
            );
            throw new TemplateNotFoundException(json_encode($exception));
        }

        $this->templateManager->setTemplate($template);

        return $this->templateManager;
    }
}
