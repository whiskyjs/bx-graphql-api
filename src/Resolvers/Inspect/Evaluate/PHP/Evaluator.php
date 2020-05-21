<?php

namespace WJS\API\Resolvers\Inspect\Evaluate\PHP;

class Evaluator
{
    /**
     * @param string $source
     * @return EvaluationResult
     */
    public static function evaluate(string $source): EvaluationResult
    {
        $result = new EvaluationResult();

        try {
            ob_start();
            $result->setResult((string) eval($source));
            $result->setOutput(ob_get_clean());
        } catch (\Throwable $e) {
            $result->setOutput(sprintf(
                "[%s: %s]",
                get_class($e),
                $e->getMessage()
            ));
        }

        return $result;
    }
}
