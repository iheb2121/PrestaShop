<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Core\Image\Exception\ImageFormatConfigurationException;
use PrestaShop\PrestaShop\Core\Image\ImageFormatConfiguration;

class ImageFormatConfigurationTest extends TestCase
{
    /**
     * @dataProvider testGetGenerationFormatsProvider
     *
     * @param string $confData
     * @param array $expectedResult
     *
     * @return void
     */
    public function testGetGenerationFormats(string $confData, array $expectedResult): void
    {
        $configuration = $this->getMockBuilder(Configuration::class)
            ->getMock();

        $configuration->method('get')->willReturn($confData);

        $imageFormatConfiguration = new ImageFormatConfiguration($configuration);

        $result = $imageFormatConfiguration->getGenerationFormats();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Checks that wrong format throw right exception in addInvalidGenerationFormat method
     *
     * @return void
     *
     * @throws ImageFormatConfigurationException
     */
    public function testAddInvalidGenerationFormat(): void
    {
        $configuration = $this->getMockBuilder(Configuration::class)
            ->getMock();
        $imageFormatConfiguration = new ImageFormatConfiguration($configuration);

        $this->expectException(ImageFormatConfigurationException::class);

        $imageFormatConfiguration->addGenerationFormat('does_not_exist');
    }

    /**
     * Checks that wrong format throw right exception in setListOfGenerationFormats method
     *
     * @dataProvider setListOfGenerationFormatsProvider
     *
     * @param array $formatList
     *
     * @return void
     */
    public function testSetListOfGenerationFormats(array $formatList): void
    {
        $configuration = $this->getMockBuilder(Configuration::class)
            ->getMock();
        $imageFormatConfiguration = new ImageFormatConfiguration($configuration);

        $this->expectException(ImageFormatConfigurationException::class);

        $imageFormatConfiguration->setListOfGenerationFormats($formatList);
    }

    /**
     * @dataProvider isGenerationFormatSetProvider
     *
     * @param string $input
     * @param string $confData
     * @param bool $expectedResult
     *
     * @return void
     */
    public function testIsGenerationFormatSet(string $input, string $confData, bool $expectedResult): void
    {
        $configuration = $this->getMockBuilder(Configuration::class)
            ->getMock();
        $configuration->method('get')->willReturn($confData);
        $imageFormatConfiguration = new ImageFormatConfiguration($configuration);

        $this->assertEquals($expectedResult, $imageFormatConfiguration->isGenerationFormatSet($input));
    }

    /**
     * @return array[]
     */
    public function testGetGenerationFormatsProvider(): array
    {
        return [
            ['jpg,png,webp', ['jpg', 'png', 'webp']],
            ['jpg', ['jpg']],
            ['png,avif', ['png', 'avif']],
        ];
    }

    /**
     * @return array[]
     */
    public function setListOfGenerationFormatsProvider(): array
    {
        return [
            [['jpg', 'png', 'fake']],
            [['fake']],
        ];
    }

    /**
     * @return array[]
     */
    public function isGenerationFormatSetProvider()
    {
        return [
            ['jpg', 'png,avif,webp', false],
            ['jpg', 'jpg,avif,webp', true],
            ['jpg', '', false],
            ['png', 'webp', false],
        ];
    }
}
