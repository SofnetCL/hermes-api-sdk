<?php

namespace HermesSdk;

enum Status: string
{
    case Pending = 'pending';
    case Sent = 'sent';
    case Failed = 'failed';
    case Retried = 'retried';
}
