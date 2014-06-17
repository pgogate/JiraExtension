<?php
/**
 * @copyright 2012 Anthon Pang
 * @license MIT
 */

namespace VIPSoft\JiraExtension;

use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * A Jira Feature Loader extension for Behat
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class Extension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/services'));
        $loader->load('core.xml');

        if (isset($config['host'])) {
            $container->setParameter('behat.jira.host', rtrim($config['host'], '/'));
        }
        if (isset($config['user'])) {
            $container->setParameter('behat.jira.user', $config['user']);
        }
        if (isset($config['password'])) {
            $container->setParameter('behat.jira.password', $config['password']);
        }
        if (isset($config['jql'])) {
            $container->setParameter('behat.jira.jql', $config['jql']);
        }
        if (isset($config['comment_on_pass'])) {
            $container->setParameter('behat.jira.comment_on_pass', $config['comment_on_pass']);
        }
        if (isset($config['comment_on_fail'])) {
            $container->setParameter('behat.jira.comment_on_fail', $config['comment_on_fail']);
        }
        if (isset($config['reopen_on_fail'])) {
            $container->setParameter('behat.jira.reopen_on_fail', $config['reopen_on_fail']);
        }
        if (isset($config['feature_field'])) {
            $container->setParameter('behat.jira.feature_field', $config['feature_field']);
        }
        if (isset($config['push_issue'])) {
            $container->setParameter('behat.jira.push_issue', $config['push_issue']);
        }
        if (isset($config['ignored_statuses'])) {
            $container->setParameter('behat.jira.ignored_statuses', $config['ignored_statuses']);
        }
        if (isset($config['tag_pattern'])) {
            $container->setParameter('behat.jira.tag_pattern', $config['tag_pattern']);
        }
        if (isset($config['cache_directory'])) {
            $directory = realpath(rtrim($config['cache_directory'], '/'));
            $container->setParameter('behat.jira.cache_directory', $directory);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
        $builder->
            children()->
                scalarNode('host')->
                    defaultNull()->
                end()->
                scalarNode('user')->
                    defaultNull()->
                end()->
                scalarNode('password')->
                    defaultNull()->
                end()->
                scalarNode('jql')->
                    defaultNull()->
                end()->
                scalarNode('push_issue')->
                    defaultFalse()->
                end()->
                scalarNode('comment_on_pass')->
                    defaultFalse()->
                end()->
                scalarNode('comment_on_fail')->
                    defaultFalse()->
                end()->
                scalarNode('reopen_on_fail')->
                    defaultFalse()->
                end()->
                scalarNode('feature_field')->
                    defaultValue('description')->
                end()->
                scalarNode('cache_directory')->
                    defaultNull()->
                end()->
                scalarNode('tag_pattern')->
                    defaultValue('/jira:(.*)/')->
                end()->
                scalarNode('ignored_statuses')->
                    defaultNull()->
                end()->
            end()->
        end();
    }

    /**
     * {@inheritdoc}
     */
    public function getCompilerPasses()
    {
        return array();
    }
}
