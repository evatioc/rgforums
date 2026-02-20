<?php

class PageController {
  public static function getNavLinks(): array {
    return [
      'Home' => '/',
      'Forums' => '/forum',
      'Team' => '/team',
      'FAQ' => '/faq',
      // Store is external, handled in view
    ];
  }

  public static function landing(): void {
    View::render('page/landing', [
      'title' => 'Refined Roleplay | FiveM Roleplay',
      'is_landing' => true
    ]);
  }

  public static function team(): void {
    View::render('page/team', [
      'title' => 'Team | Refined Roleplay'
    ]);
  }

  public static function faq(): void {
    View::render('page/faq', [
      'title' => 'FAQ | Refined Roleplay'
    ]);
  }
}
