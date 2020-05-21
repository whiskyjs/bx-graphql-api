<?php

namespace WJS\API\Resolvers\Inspect\Evaluate\PHP;

class EvaluationResult implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $result = "";

    /**
     * @var string
     */
    protected $output = "";

    public function __construct(string $result = "", string $output = "")
    {
        $this
            ->setResult($result)
            ->setOutput($output);
    }

    /**
     * @param string $result
     * @return EvaluationResult
     */
    public function setResult(string $result): EvaluationResult
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * @param string $output
     * @return EvaluationResult
     */
    public function setOutput(string $output): EvaluationResult
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return string
     */
    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            "output" => $this->getOutput(),
            "result" => $this->getResult(),
        ];
    }
}
