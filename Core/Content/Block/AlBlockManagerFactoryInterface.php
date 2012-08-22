<?php
/*
 * This file is part of the AlphaLemon CMS Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Repository\BlockRepositoryInterface;

/**
 * AlBlockManagerFactory creates a BlockManager object
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
interface AlBlockManagerFactoryInterface
{
    /**
     * Creates an instance of an AlBlockManager object
     *
     * @param mixed string | \AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock $block
     *
     * @return null|\AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\class
     */
    public function createBlockManager($block);
}