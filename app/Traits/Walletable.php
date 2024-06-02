<?php

namespace App\Traits;

use App\Enum\WalletTransactionTypeEnum;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Walletable
{
    protected ?float $walletCurrent;

    protected ?float $walletStep;

    protected ?float $walletBalance;

    protected ?string $walletType;

    protected ?string $transactionType;

    protected ?string $actionMethod = 'create';

    protected ?string $transactionReason = null;

    protected ?array $walletData = [];

    protected ?int $storeId = null;

    protected ?int $packageId = null;

    protected ?int $createdById = null;

    protected ?int $subscriptionId = null;

    protected ?float $appGain = null;

    protected ?string $createdByType = null;
    protected ?string $isFiltered = null;

    public function walletType($walletType, $transactionType): static
    {
        $this->walletType = $walletType;
        $this->transactionType = $transactionType;

        return $this;
    }

    public function walletTransactionReason($transactionReason = null): static
    {
        $this->transactionReason = $transactionReason;

        return $this;
    }

    public function walletSteps(float $steps, bool $withFloat = false): static
    {
        $this->walletStep = (float)abs($steps);
        if ($this->transactionType === WalletTransactionTypeEnum::WITHDRAWAL) {
            if ($withFloat) {
                $this->walletStep = $steps * -1;
            } else {
                $this->walletStep = (float)gmp_neg($steps);
            }
        }

        return $this;
    }

    public function walletData(array $data): static
    {
        $this->walletData[] = $data;

        return $this;
    }

    public function walletDataAsJson(array $data): static
    {
        $this->walletData = $data;

        return $this;
    }

    public function walletCreate()
    {
        $this->walletCurrent = $this->walletBalance($this->walletType, $this->storeId) ?? 0;

        if ($this->actionMethod === 'create') {
            return $this->wallet($this->walletType)->create([
                'type' => $this->walletType,
                'transaction_reasons' => $this->transactionReason,
                'transaction_type' => $this->transactionType,
                'current' => $this->walletCurrent,
                'steps' => $this->walletStep,
                'balance' => $this->walletCurrent + $this->walletStep,
                'data' => $this->walletData,
            ]);
        }
    }

    public function walletBalance($walletType, $walletTransactionReasons = null)
    {
        return $this->wallet($walletType, $walletTransactionReasons)->sum('steps');
    }

    public function wallet($walletType = null, $walletTransactionReasons = null): MorphMany
    {
        $relation = $this->morphMany(Wallet::class, 'wallettable');
        $relation->when($walletType, function ($relation, $walletType) {
            $relation->whereType($walletType);
        })->when($walletTransactionReasons, function ($relation, $walletTransactionReasons) {
            $relation->whereTransactionReasons($walletTransactionReasons);
        });

        return $relation;
    }
}
