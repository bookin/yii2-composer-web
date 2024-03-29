<?php
namespace bookin\composer\web;


use Composer\Console\Application;
use Composer\Json\JsonValidationException;
use Composer\Factory;

class WebApplication extends Application
{
    /**
     * @param $composer
     */
    public function setComposer($composer){
        $this->composer = $composer;
    }

    /**
     * @param bool|true $required
     * @param bool|false $disablePlugins
     * @return \Composer\Composer
     * @throws JsonValidationException
     */
    public function getComposer($required = true, $disablePlugins = false)
    {
        if (null === $this->composer) {
            try {
                $this->composer = Factory::create($this->io, null, $disablePlugins);
            } catch (\InvalidArgumentException $e) {
                if ($required) {
                    $this->io->writeError($e->getMessage());
                    throw new \InvalidArgumentException($e->getMessage());
                }
            } catch (JsonValidationException $e) {
                $errors = ' - ' . implode(PHP_EOL . ' - ', $e->getErrors());
                $message = $e->getMessage() . ':' . PHP_EOL . $errors;
                throw new JsonValidationException($message);
            }
        }

        return $this->composer;
    }
}