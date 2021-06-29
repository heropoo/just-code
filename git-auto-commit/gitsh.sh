#!/usr/bin/env bash
# Copyright (c) 2013 Alvin Abad
# sed $'s/\r$//' ./gitsh.sh > ./gitsh-unix.sh
if [ $# -eq 0 ]; then
    echo "Git wrapper script that can specify an ssh-key file
    Usage:
    gitsh -i ssh-key-file git-command
    "
    exit 1
fi

# remove temporary file on exit
trap 'rm -f /tmp/.git_ssh.$$' 0
if [ "$1" = "-i" ]; then
    SSH_KEY=$2; shift; shift
    echo "ssh -i $SSH_KEY \$@" > /tmp/.git_ssh.$$
    chmod +x /tmp/.git_ssh.$$
    export GIT_SSH=/tmp/.git_ssh.$$
fi
# in case the git command is repeated
[ "$1" = "git" ] && shift
# Run the git command
git "$@"