<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CheckboxList extends AbstractHelper
{
    public function __invoke(array $list, $name, $checked)
    {
        $html = [];
        foreach ($list as $key => $title) {
            $inputName = "{$name}[{$key}]";
            $html[] =
                '<input type="checkbox"
                        value="1" 
                        id="' . $inputName . '" 
                        name="' . $inputName . '"' . ($checked ? 'checked="checked"' : null) .'/>' .
                '<label for="' . $inputName . '">' . $title . '</label>';
        }

        return implode('&nbsp;', $html);
    }
}