<?php

namespace xianrenqh\Apidoc2Webman\annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * 排除模型的字段
 * @package hg\apidoc\annotation
 * @Annotation
 * @Target({"METHOD"})
 */
class WithoutField extends Annotation
{}
