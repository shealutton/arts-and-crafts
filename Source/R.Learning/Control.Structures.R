if() {
  # do something
} else if{
  # somthing else
} else {
  # somthing
}

# Fun with FOR LOOPS
for(i in 1:10) {
  print(i)
}

x <- c("a", "b", "c", "d")
for (i in 1:4) {
  print(x[i])
}
for(i in seq_along(x)) {
  print(x[i])
}
for(letter in x) {
  print(letter)
}
# for a single expression only
for (i in 1:4) print(x[i])

m <- matrix(1:6, 2, 3)
m
for(i in seq_len(nrow(m))) {
  for(j in seq_len(ncol(m))) {
    print(m[i, j])
  }
}


# WHILE LOOPS
i <- 0
while(i < 10) {
  i <- i + 1
  print(i)
}

# A random walk thanks to rbinom
z <- 5
while(z >= 3 && z <= 10) {
  print(z)
  coin <- rbinom(1,1,0.5)

  if(coin == 1) { # random walk 
    z <- z + 1 
  } else {
    z <- z - 1
  }
}
 
# REPEAT LOOPS (an infinate loop, you must call break to exit)
# useful in optimization, maximization, etc when you want to run until you find the best value
# an example where the estimate and the number are below a tollerance. A sign
# that you are converging on the best/true value
# repeat() your algo must eventually converge (not all do) and that it will run in a reasonable time
# break is the only exit for a repeat loop. Can be used other places too. 
x0 <- 1
tollerance <- 1e-8
repeat {
  x1 <- computeEstimate()
  if(abs(x1 - x0) < tollerance) {
    break
  } else {
    x0 <- x1
  }
}

# NEXT skips to the next value
for(i in 1:25) {
  if(i <= 20) {
    next
  }
  print(i)
}

# RETURN exits functions or loops
return()

# In CLI use, the *apply can be much more useful than loops
# better for interactive use. 









