cd  /application/app/Models/ && find -type f -name '*.php' -not -name 'RecordableModel.php' -exec sed -i 's#Illuminate\\Database\\Eloquent\\Model#App\\Models\\RecordableModel as Model#' {} \;
