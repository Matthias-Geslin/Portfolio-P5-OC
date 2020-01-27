'use strict';


class Rpg {
    constructor(hp, strength) {
        this.action = document.getElementById('hit');
        this.defend = document.getElementById('defend');

        // Fixed statistics
        this.characterStatsName              = document.getElementById('stats-name');
        this.characterStatsHp                = document.getElementById('stats-hp');
        this.characterStatsStrength          = document.getElementById('stats-strength');

        // In Fight Statistics
        this.characterHp                     = document.getElementById('character-hp');
        this.characterName                   = document.getElementById('character-name');
        this.characterDamages                = this.characterStatsStrength * 0.75;

        // Monster stats randomized
        this.monsterHp                       = this.randomNbr(20,50);
        this.monsterMp                       = this.randomNbr(0,50);
        this.monsterStrength                 = this.randomNbr(1,10);
        this.monsterDamages                  = this.monsterStrength * 0.75;

        this.healthPoints = hp;
        this.strength = strength;
    }

    getStats() {
        return this.healthPoints + this.strength;
    }
}

Rpg.prototype.begin = function () {
    this.selected();
    this.startBattle();
    this.menu();
    this.characterName.innerHTML = 'Name: ' + this.characterStatsName.value;
    this.characterHp.innerHTML ='HP: ' + this.characterStatsHp.value;
};

Rpg.prototype.selected = function () {
    if('Warrior') {
        this.Rpg(44, 2).getStats();
    }
    if('Sorcerer') {
        this.Rpg(44, 3).getStats();
    }
    if('Archer') {
        this.Rpg(40,1).getStats();
    }
};

Rpg.prototype.menu = function () {
    const battle = document.getElementById('battle');

    this.action.addEventListener('click', function () {
        battle.innerHTML = 'Hit the monster !';
        this.monsterHp = this.monsterHp - this.characterDamages;
        monsterHp.innerHTML = 'Hp: ' + this.monsterHp;
    });

    this.defend.addEventListener('click', function () {
        battle.innerHTML = 'Back to defense !';
    });
};

Rpg.prototype.startBattle = function() {
    let monsterHp = document.getElementById('monster-hp');
    monsterHp.innerHTML = 'Hp: ' + this.monsterHp;
    let monsterMp = document.getElementById('monster-mp');
    monsterMp.innerHTML = 'Mp: ' + this.monsterMp;
};

Rpg.prototype.randomNbr = function(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min +1)) + min;
};