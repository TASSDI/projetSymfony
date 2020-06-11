df=read.csv("utilise.csv",sep=",")
summary(df)
df.cr<-dist(df) 
cah.ward<-hclust(df.cr,method="ward.D2")  
plot(cah.ward) 
rect.hclust(cah.ward,k=4) 
groupe.cah<-cutree(cah.ward,k=4)
print(sort(groupe.cah))

groupe.kmeans<-kmeans(df.cr,centers=3,nstart=5)
print(groupe.kmeans) 

inertie.expl <- rep(0,times=10)
for (k in 2:10){
clus <- kmeans(df.cr,centers=k,nstart=5)
inertie.expl[k] <- clus$betweenss/clus$totss
}

plot(1:10,inertie.expl,type="b",xlab="Nb. de groupes",ylab="% inertie expliquée")

library(fpc)

sol.kmeans <- kmeansruns(df.cr,krange=2:10,criterion="ch")
plot(1:10,sol.kmeans$crit,type="b",xlab="Nb. de groupes",ylab="Silhouette")


