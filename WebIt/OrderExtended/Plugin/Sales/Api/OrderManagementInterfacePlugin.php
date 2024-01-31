<?php
declare(strict_types=1);

namespace WebIt\OrderExtended\Plugin\Sales\Api;

use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Psr\Log\LoggerInterface;
use Exception;

/**
 * Class OrderManagementInterfacePlugin
 */
class OrderManagementInterfacePlugin
{
    /**
     * @var string
     */
    public const TOPIC = 'webit.order.create';

    /**
     * @var PublisherInterface
     */
    protected $publisher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param PublisherInterface $publisher
     * @param LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        LoggerInterface $logger
    )
    {
        $this->publisher = $publisher;
        $this->logger = $logger;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterPlace(OrderManagementInterface $subject, OrderInterface $order): OrderInterface
    {
        try {
            $this->publisher->publish(static::TOPIC, $order->getId());
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $order;
    }
}
