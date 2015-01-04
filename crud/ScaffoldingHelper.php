<?php
/**
 * Helper for process scaffolding
 *
 * @author daweb
 */

namespace daweb\crud;

class ScaffoldingHelper {

    const FILE_HISTORY = 'history.txt';
    /**
     * last path to file controller
     * @var string
     */
    private $history;

    /**
     * Save path last created crud file
     */
    public function saveToHistory($path) {

        return file_put_contents(static::FILE_HISTORY, $path);
    }

    /**
     * Get path last created crud file
     */
    public function getHistory() {

        if ($this->history) {
            return $this->history;
        }

        if (file_exists(static::FILE_HISTORY)) {

            $history = file_get_contents(static::FILE_HISTORY);

            if (file_exists($history)) {
                return $history;
            }
        }
    }

}
