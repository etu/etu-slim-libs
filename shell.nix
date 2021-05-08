{ pkgs ? (import <nixpkgs> {}) }:

let
  php' = pkgs.php80;

in pkgs.mkShell {
  buildInputs = [
    # Install PHP and composer
    php'
    php'.packages.composer
  ];
}
