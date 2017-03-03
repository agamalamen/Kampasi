<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoulMate;
use App\Choice;
use App\Http\Requests;

class SoulMateController extends Controller
{
    public function getSoulMate()
    {
      return view('soul-mate.soul-mate');
    }

    public function postSoulMate($name, $answers)
    {
      $answersArray = array();
      $tags = $answers;
      $startPoint = 0;
      while (strpos($tags, ',') !== false) {
        $breakPoint = strcspn($tags,",");
        array_push($answersArray, substr($tags, $startPoint, $breakPoint));
        $tags = substr($tags, $breakPoint+1);
      }
      array_push($answersArray, $tags);

      $soulMate = new SoulMate();
      $soulMate->name = $name;
      $soulMate->answers = serialize($answersArray);
      $soulMate->save();
      return redirect()->route('get.soul.mate.result');
    }

    public function proccessSoulMate()
    {
      $soulMates = SoulMate::all();
      foreach ($soulMates as $soulMate) {
        $answers = unserialize($soulMate->answers);
        foreach ($answers as $answer) {
          echo $answer;
        }
      }
    }

    public function getSoulMateResult()
    {
      return view('soul-mate.soul-mate-result');
    }

    public function getMatching($id)
    {
      $soulMates = SoulMate::all();
      /*$i = 1;
      foreach ($soulMates as $soulMate) {
        $soulMate->match = $i;
        $soulMate->update();
        if ($i == 64) {
          $i = 1;
        }
        $i++;
      }*/
      echo '<table style="border= 1px;">';
      $i = 1;
      foreach ($soulMates as $soulMate) {
        foreach ($soulMates as $otherSoul) {
          if ($soulMate->match == $otherSoul->match && $soulMate != $otherSoul) {
            echo '<tr>';
            echo '<td>' . $i . '. ' .$soulMate->name . '</td> <td>' . $otherSoul->name . '</td>';
            echo '</tr>';
          }
        }
        if ($i == 64) {
          break;
        }
        $i++;
      }

      echo '</table>';

      //return $userAnswers . '<br>' . $soulMateAnswers;
      //$soulMates = SoulMate::take(167);
      //$matches = 0;
      //$yourSoulMate = 0;
      /*foreach ($soulMates as $soulMate) {
        $newMatches = 0;
        $soulMateAnswers = unserialize($soulMate->answers);
        if ($soulMate->id != $user->id) {
            $i = 1;
            while ($i < 16) {
              if ($userAnswers[$i] == $soulMateAnswers[$i]) {
                $newMatches++;
              }
              $i++;
            }
        }
        if ($newMatches > $matches) {
          $matches = $newMatches;
          $yourSoulMate = $soulMate->id;
        }
      }*/
      //return $yourSoulMate;
    }
}
