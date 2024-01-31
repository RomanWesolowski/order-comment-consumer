<?php
declare(strict_types=1);

namespace WebIt\OrderExtended\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Exception;

/**
 * Class OrderConsumer
 */
class OrderConsumer
{
    /**
     * @var string
     */
    public const ORDER_COMMENT_CONFIG_PATH = 'order_extended/settings/comment';

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * @param string $orderId
     * @return void
     */
    public function processOrder(string $orderId): void
    {
        try {
            if ($comment = $this->getComment()) {
                $order = $this->orderRepository->get((int)$orderId);
                $order->addCommentToStatusHistory($comment);
                $this->orderRepository->save($order);
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->scopeConfig->getValue(static::ORDER_COMMENT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
}
