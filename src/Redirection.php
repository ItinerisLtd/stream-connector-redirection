<?php

declare(strict_types=1);

namespace Itineris\StreamConnectorRedirection;

use Red_Item;
use WP_Stream\Connector;

class Redirection extends Connector {
    public $name = 'redirection';

    public $actions = [
        'redirection_redirect_deleted',
        'redirection_redirect_updated',
    ];

    public function get_label(): string
    {
        return __('Redirection', 'stream-connector-redirection');
    }

    public function get_context_labels(): array
    {
        return [
            'admin' => __('Admin', 'stream-connector-redirection'),
        ];
    }

    public function get_action_labels(): array
    {
        return [
            'visited' => __('Visited', 'stream-connector-redirection'),
        ];
    }

    public function callback_redirection_redirect_updated(int|Red_Item $insert, Red_Item $item): void
    {
        if ($insert instanceof Red_Item) {
            $action = 'updated';
        } else {
            $action = 'created';
        }

        $from = $item->get_url();
        $to = $item->get_action_data();
        $message = __('Redirect %1$s -> %2$s %3$s', 'stream-connector-redirection');
        $args = array_merge(
            [
                'from' => $from,
                'to' => $to,
                'status' => $action,
            ],
            $this->get_redirect_data($item),
        );

        $this->log(
            $message,
            $args,
            $item->get_id(),
            'Redirects',
            $action,
        );
    }

    public function callback_redirection_redirect_deleted(Red_Item $item): void
    {
        $from = $item->get_url();
        $to = $item->get_action_data();
        $message = __('Redirect %1$s -> %2$s deleted', 'stream-connector-redirection');
        $args = array_merge(
            [
                'from' => $from,
                'to' => $to,
            ],
            $this->get_redirect_data($item),
        );

        $this->log(
            $message,
            $args,
            $item->get_id(),
            'Redirects',
            'deleted',
        );
    }

    protected function get_redirect_data(Red_Item $item): array {
        return [
            'title' => $item->get_url(),
            'id' => $item->get_id(),
            'url' => $item->get_url(),
        ];
    }
}
