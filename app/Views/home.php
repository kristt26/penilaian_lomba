<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="dashboardController">
    <h1 class="h3 mb-4 text-gray-800">{{setTitle}}</h1>
    <p>{{paragraph}}</p>
</div>
<?= $this->endSection() ?>