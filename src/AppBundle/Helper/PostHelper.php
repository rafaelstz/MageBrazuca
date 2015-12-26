<?php

namespace AppBundle\Helper;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Templating\Helper\Helper;
use Gaufrette\File;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class PostHelper extends Helper
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'postHelper';
    }

    public function getFormattedDate(\DateTime $createdAt)
    {
        $interval = $createdAt
            ->diff(new \DateTime());

        $outputData = array(
            'year' => array(
                'value' => $interval->format('%y'),
                'label' => ($interval->format('%y') == 1) ?
                    sprintf('%s ano', $interval->format('%y')) :
                    sprintf('%s anos', $interval->format('%y')),
            ),
            'month' => array(
                'value' => $interval->format('%m'),
                'label' => ($interval->format('%m') == 1) ?
                    sprintf('%s mês', $interval->format('%m')) :
                    sprintf('%s messes', $interval->format('%m')),
            ),
            'day' => array(
                'value' => $interval->format('%d'),
                'label' => ($interval->format('%d') == 1) ?
                    sprintf('%s dia', $interval->format('%d')) :
                    sprintf('%s dias', $interval->format('%d')),
            ),
            'hour' => array(
                'value' => $interval->format('%h'),
                'label' => ($interval->format('%h') == 1) ?
                    sprintf('%s hora', $interval->format('%h')) :
                    sprintf('%s horas', $interval->format('%h')),
            ),
            'minute' => array(
                'value' => $interval->format('%i'),
                'label' => ($interval->format('%i') == 1) ?
                    sprintf('%s minuto', $interval->format('%i')) :
                    sprintf('%s minutos', $interval->format('%i')),
            ),
            'second' => array(
                'value' => $interval->format('%s'),
                'label' => ($interval->format('%s') == 1) ?
                    sprintf('%s segundo', $interval->format('%s')) :
                    sprintf('%s segundos', $interval->format('%s')),
            ),
        );

        $data = $this->applyDateRule($outputData);

        if (count($data) == 1) {
            $output = $data[0];
        } else {
            $output = sprintf(
                '%s e %s',
                $data[0],
                $data[1]
            );
        }

        $output .= ' atrás';

        return $output;
    }

    private function applyDateRule($data)
    {
        $items = array();

        foreach ($data as $itemKey => $item) {
            if ($item['value'] > 0) {
                if (
                       isset($data[$itemKey + 1]['value'])
                    && $data[$itemKey + 1]['value'] > 0
                ) {
                    return array(
                        $data[$itemKey]['label'],
                        $data[$itemKey + 1]['label'],
                    );
                } else {
                    return array(
                        $data[$itemKey]['label'],
                    );
                }
            }
        }

        return $items;
    }

    public function getFormattedTag($tag)
    {
        if (!$tag) {
            return '';
        }

        $tagsExploded = explode(',', $tag);

        $tags = array();

        foreach ($tagsExploded as $tagExploded) {
            $tags[] = sprintf(
                '<a href="/tag/%s" class="post-tag">%s</a>',
                trim($tagExploded),
                trim($tagExploded)
            );
        }

        return implode(', ', $tags);
    }
}
