<?php

namespace Core;

class Command
{
  /**
   * The Laravel application instance.
   *
   * @var \Illuminate\Application\Application
   */
  protected $app;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature;

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name;

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description;

  /**
   * The name of argument being used.
   *
   * @var string
   */
  protected $argumentName;

  /**
   * The console command help text.
   *
   * @var string
   */
  protected $help;

  /**
   * Indicates whether the command should be shown in the Artisan command list.
   *
   * @var bool
   */
  protected $hidden = false;

  public function getName()
  {
    return $this->name;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function getArgumentName()
  {
    return $this->argumentName;
  }
  public function isHidden()
  {
    return $this->hidden == true;
  }
}
