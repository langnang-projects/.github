<?php


return [
    /**
     * How to handle raw HTML
     * Set this option to one of the following strings: 
     * @return string strip: Strip all HTML from the input
     * @return string escape: Escape all raw HTML input
     * @return string allow: Allow all HTML input as-is (default value; equivalent to `‘safe’ => false)
     */
    'html_input' => 'allow',
    /**
     * Whether unsafe links are permitted
     * Remove risky link and image URLs by setting this to false (default: true)
     */
    'allow_unsafe_links' => false,
    /**
     * Protected against long render times or segfaults
     * The maximum nesting level for blocks (default: PHP_INT_MAX). 
     * Setting this to a positive integer can help protect against long parse times and/or segfaults if blocks are too deeply-nested.
     */
    'max_nesting_level' => PHP_INT_MAX,
    /**
     * Array of options for rendering HTML 
     */
    'renderer' => [
        /**
         * String to use for separating renderer block elements
         */
        'block_separator' => "\n",
        /**
         * String to use for separating inner block contents
         */
        'inner_separator' => "\n",
        /**
         * String to use for rendering soft breaks
         */
        'soft_break' => "\n",
    ],
    'commonmark' => [
        /**
         * Array of options for configuring the CommonMark core extension: 
         */
        'enable_em' => true,
        'enable_strong' => true,
        'use_asterisk' => true,
        'use_underscore' => true,
        'unordered_list_markers' => ['-', '*', '+'],
    ],
    /**
     * Array of options for configuring how URL-safe slugs are created
     */
    'slug_normalizer' => [
        'max_length' => 255,
    ],
];