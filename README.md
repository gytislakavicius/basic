sudo game
=====

# Launching VM

Run following commands to launch VM:
- vagrant plugin install vagrant-hostmanager
- vagrant up
- sudo vim "192.168.59.103 game.dev" >> /etc/hosts


Now page should be reachable via `http://game.dev`