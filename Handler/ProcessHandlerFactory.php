<?php

namespace FreeAgent\WorkflowBundle\Handler;

use FreeAgent\WorkflowBundle\Model\ModelStorage;
use FreeAgent\WorkflowBundle\Exception\WorkflowException;

class ProcessHandlerFactory
{
    /**
     * @var array
     */
    protected $processes;

    /**
     * @var string
     */
    protected $processHandlerClass;

    /**
     * Construct.
     *
     * @param array  $processes
     * @param string $processHandlerClass
     */
    public function __construct(array $processes, $processHandlerClass)
    {
        $this->processes           = $processes;
        $this->processHandlerClass = $processHandlerClass;
    }

    /**
     * Returns a process by its name.
     *
     * @param string $name
     * @return FreeAgent\WorkflowBundle\Flow\Process
     *
     * @throws WorkflowException
     */
    public function getProcess($name)
    {
        if (!isset($this->processes[$name])) {
            throw new WorkflowException(sprintf('Unknown process "%s"', $name));
        }

        return $this->processes[$name];
    }

    /**
     * Create a new ProcessHandler for the given process.
     *
     * @param string $processName
     * @return \FreeAgent\WorkflowBundle\Manager\ProcessHandlerInterface
     */
    public function createProcessHandler($processName, ModelStorage $storage)
    {
        $class = $this->processHandlerClass;
        $handler = new $class($this->getProcess($processName), $storage);

        return $handler;
    }
}