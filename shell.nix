{ pkgs ? (import <nixpkgs> {}) }:

let
  php' = pkgs.php80;

in pkgs.mkShell {
  buildInputs = [
    # Install PHP and composer
    php'
    php'.packages.composer

    # Install nodejs for PHP LSP to work
    pkgs.nodejs
  ];
}
